<?php
/**
 * Created by PhpStorm.
 * User: tleclere
 * Date: 23/09/2016
 * Time: 11:37
 */

namespace TodoBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;
use TodoBundle\Entity\EtatTache;
use TodoBundle\Entity\Tache as EntityTache;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class Tache
{
    private $em;
    private $token;

    public function __construct(EntityManagerInterface $em,TokenStorageInterface $token){
        $this->em = $em;
        $this->token = $token;
    }

    /**
     * Save tache
     * @param EntityTache $tache
     * @param Request $request
     * @return bool
     */
    public function saveTache(EntityTache $tache, Request $request){

        try{
            $user = $this->token->getToken()->getUser();
            $tache->setDateCreation(new \DateTime());
            $tache->setUser($user);
            $this->em->persist($tache);
            $this->em->flush();

            $request->getSession()->getFlashBag()->add('success',"Project ".$tache->getNom()." has been added");
            return true;

        }catch (ORMException $e){
            $request->getSession()->getFlashBag()->add('error',$e->getMessage());
            return false;
        }

    }

    /**
     * Get taches by projet and etat in order to display taches in the right column
     * @param null $id_projet
     * @return array
     */
    public function getTachesByProjet($id_projet = null){

        $taches = array();//array that will be returned

        $tacheRepository = $this->em->getRepository("TodoBundle:Tache");

        $projet = (!is_null($id_projet)) ? $this->em->getRepository("TodoBundle:Projet")->find($id_projet) : null;

        $colonnes = array("a_faire","en_cours","finis","en_attente");
        foreach($colonnes as $colonne){
            $taches[$colonne] = $tacheRepository->findByEtat($this->getEtatByColonne($colonne),$projet);
        }

        return $taches;

    }

    /**
     * Return the name of the etat
     * @param $id_colonne
     * @return string
     */
    public function getEtatByColonne($id_colonne) {

        $etatRepo = $this->em->getRepository("TodoBundle:Etat");
        $etat = $etatRepo->findOneBy(array("nom"=>"A faire"));
        switch($id_colonne) {
            case "a_faire":
                $etat = $etatRepo->findOneBy(array("nom"=>"A faire"));
            break;
            case "en_cours":
                $etat = $etatRepo->findOneBy(array("nom"=>"En cours"));
            break;
            case "finis":
                $etat = $etatRepo->findOneBy(array("nom"=>"Terminé"));
            break;
            case "en_attente":
                $etat = $etatRepo->findOneBy(array("nom"=>"En attente"));
            break;
            default: null; break;
        }
        return $etat;
    }

    /**
     *
     * @param $tache
     * @param $etat
     */
    public function changeEtatTache($tache,$etat) {

        try {
            $tache->setEtat($etat);

            $etat_precedents = $this->em->getRepository("TodoBundle:EtatTache")->findBy(array("tache"=>$tache));
            foreach($etat_precedents as $etat_prec) {
                if(is_null($etat_prec->getDateFin())) {
                    $etat_prec->setDateFin(new \DateTime());
                }
                $this->em->persist($etat_prec);
            }

            $this->em->persist($tache);
            $this->em->flush();

            $etat_tache = new EtatTache();
            $etat_tache->setDateDebut(new \DateTime());
            $etat_tache->setEtat($etat);
            $etat_tache->setTache($tache);

            $this->em->persist($etat_tache);
            $this->em->flush();

            return array("success"=>true,"message"=>"The status of task has been changed");

        }catch (ORMException $e){
            return array("success"=>false,"message"=>$e->getMessage());
        }

    }


    public function getSpentTime($tache,$etat) {

        $tacheRepo = $this->em->getRepository("TodoBundle:Tache");

        $data = $tacheRepo->->getSpentTime($tache->getId());

        if(is_null($data['tempsPasser'])) {
            //todo calcul du temps
            $date_debut = $data['date_debut'];
            $date_fin = $data['date_fin'];
        }else{
            return $data['tempsPasser'];
        }

    }
}