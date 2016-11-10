<?php

namespace TodoBundle\Service;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use TodoBundle\Entity\Projet;

class Stats
{

    private $em;
    private $container;

    public function __construct(EntityManagerInterface $em, ContainerInterface $container) {
        $this->em = $em;
        $this->container = $container;
    }

    public function getAllEndedTasks(Projet $projet=null) {

        $endedTasks = array();
        $ended = $this->em->getRepository("TodoBundle:Etat")->find(4);//ended state
        if(is_null($ended)){
            $this->container->get('session')->getFlashBag()->add('error', 'The state Ended does not exist, please init the database');
        }

        if(!is_null($projet)) {
            $endedTasks = $this->em->getRepository("TodoBundle:Tache")->findBy(array("etat"=>$ended,"projet"=>$projet));
        }

        $endedTasks = $this->em->getRepository("TodoBundle:Tache")->findBy(array("etat"=>$ended));

        return $endedTasks;

    }

}