<?php

namespace TodoBundle\Service;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use TodoBundle\Entity\Projet;
use TodoBundle\Entity\Tache;

class Stats
{

    private $em;
    private $container;

    public function __construct(EntityManagerInterface $em, ContainerInterface $container) {
        $this->em = $em;
        $this->container = $container;
    }

    public function getAllEndedTasks(Projet $projet=null) {

        $ended = $this->em->getRepository("TodoBundle:Etat")->find(4);//ended state
        if(is_null($ended)){
            $this->container->get('session')->getFlashBag()->add('error', 'The state Ended does not exist, please init the database');
            return null;
        }

        if(!is_null($projet)) {
            $endedTasks = $this->em->getRepository("TodoBundle:Tache")->findBy(array("etat"=>$ended,"projet"=>$projet));
        }else{
            $endedTasks = $this->em->getRepository("TodoBundle:Tache")->findBy(array("etat"=>$ended));
        }

        return $endedTasks;

    }


    public function getVeracityTasks($taches) {

        $nbr_taches = empty($taches) ? count($taches) : 1;
        $ratio = 0;

        foreach($taches as $tache) {
            $temps_prevu = $tache->getTempsPrevu();
            $temps_passer = $tache->getTempsPasses();

            $ratio += $temps_prevu > 0 ? $temps_passer / $temps_prevu : 0;

        }

        $veracity = ($ratio <= 1  && $nbr_taches ) ? 1 - floor($ratio / $nbr_taches) : 0;

        return $veracity;

    }

    public function getVeracityByTask(Tache $tache) {

        $temps_prevu = $tache->getTempsPrevu();
        $temps_passer = $tache->getTempsPasses();

        $ratio = $temps_prevu > 0 ? 1 - floor($temps_passer / $temps_prevu) : 0;

        return $ratio;

    }

    public function getAverageTimeByTasks($taches) {

        $nbr_taches = !empty($taches) ? count($taches) : 1;
        $moyenne = 0;
        $avgPrevu = 0;

        foreach($taches as $tache) {
            $moyenne += $tache->getTempsPasses();
            $avgPrevu += $tache->getTempsPrevu();

        }

        if($nbr_taches) {
            return array("moyenne"=>floor($moyenne / $nbr_taches),"avgPrevu"=>floor($avgPrevu / $nbr_taches));
        }

    }

}