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
     * Change the state of a task when it change the column
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


    /**
     * Get the seconds spent on a task
     * @param $tache
     */
    public function getSpentTime($tache) {

        $tacheRepo = $this->em->getRepository("TodoBundle:Tache");

        $data = $tacheRepo->getSpentTime($tache->getId());

        $tempsPasser = $tache->getTempsPasses();

        foreach($data as $data_tache) {

            if( $nbr_jours = $data_tache['nbr_jours'] ) {

                $temps_debut = $this->getTempsJour($data_tache['date_debut'],true);
                $temps_fin = $this->getTempsJour($data_tache['date_fin'],false);

                if($nbr_jours > 1) {
                    $tempsPasser += ($nbr_jours - 1 ) * 7 * 3600;
                }

                $tempsPasser += $temps_debut + $temps_fin;

            }else{
                $tempsPasser += $this->getSpentTimeForOneDay($data_tache['date_debut'],$data_tache['date_fin']);
            }

        }
        return $tempsPasser;

    }

    /**
     * Save the time spent on a task when it is finished
     * @param EntityTache $tache
     * @param $tempsPasser
     * @return array|null
     */
    public function setTempsPasserOnTask(\TodoBundle\Entity\Tache $tache,$tempsPasser) {

        $aRetour = null;
        try {
            $tache->setTempsPasses($tempsPasser);

            $etats_tache = $this->em->getRepository("TodoBundle:EtatTache")->getAllEtat_Tache($tache);

            foreach ($etats_tache as $etat_tache) {
                $this->em->remove($etat_tache);
            }
            $this->em->persist($tache);
            $this->em->flush();

            $aRetour = array("success"=>true,"Time spent on the task has been calculated");

        }catch (ORMException $e){
            $aRetour = array("success"=>false,"An error occured, time spent on the task has been not saved");
        }

        return $aRetour;

    }


    /**
     * Set the task in Corbeille Etat
     * @param EntityTache $tache
     * @return array
     */
    public function misenCorbeille(\TodoBundle\Entity\Tache $tache) {

        if(is_null($tache)){
            return array("success"=>false,"message"=>"Can't remove the task, it already does not exist");
        }

        try {
            $corbeille = $tache->getEncorbeille() ? false : true;
            $tache->setEncorbeille($corbeille);
            $this->em->persist($tache);
            $this->em->flush();
        }catch (ORMException $e) {
            return array("success"=>false,"message"=>$e->getMessage());
        }

        return array("success"=>true,"message"=>"The task has been removed");

    }


    /**
     * Retourne le temps en secondes à partir d'une heure
     * @param $date
     * @return float|int
     */
    private function getTempsJour($date,$isBegin) {

        $deb_jour = strtotime("09:00:00");
        $pause_dej = strtotime("12:30:00");
        $fin_jour = strtotime("18:00:00");
        $reprise_dej = strtotime("14:00:00");

        $heure = strtotime( explode(" ",$date)[1] );

        if($isBegin){
            if( date('H',$heure) < '12' ) {
                $temps_matin = $pause_dej - $heure;
                $temps_aprem = 4*3600;
            }else{
                $temps_matin = 0;
                $temps_aprem = $fin_jour - $heure;
            }
        }else{
            if( date('H',$heure) < '12' ) {
                $temps_matin = $heure - $deb_jour;
                $temps_aprem = 0;
            }else {
                $temps_matin = 3.5*3600;
                $temps_aprem = $heure - $reprise_dej;
            }
        }

        return $temps_matin+$temps_aprem;

    }


    /**
     * Calculate the time spent on a task that happened at one day
     * @param $date_debut
     * @param $date_fin
     * @return int
     */
    private function getSpentTimeForOneDay($date_debut,$date_fin) {

        $pause_dej = strtotime("12:30:00");
        $reprise_dej = strtotime("14:00:00");

        $heure_debut = strtotime( explode(" ",$date_debut)[1] );
        $heure_fin = strtotime( explode(" ",$date_fin)[1] );

        if( (date('H',$heure_debut) < '12' && date('H',$heure_fin) < '12') || (date('H',$heure_debut) > '12' && date('H',$heure_fin) > '12') ) {
            return $heure_fin - $heure_debut;
        }else {
            $temps_matin = $pause_dej - $heure_debut;
            $temps_aprem = $heure_fin - $reprise_dej;
            return $temps_matin+$temps_aprem;
        }

    }


    /**
     * Blocked or unblocked the task
     * @param EntityTache $tache
     */
    public function blockOrunblockTask(\TodoBundle\Entity\Tache $tache) {

        if(is_null($tache)){
            return array("success"=>false,"message"=>"the task does not exist");
        }

        try {
            $blocage = $tache->getIsBlocked() ? false : true;
            $statut = $blocage ? "blocked":"unblocked";
            $tache->setIsBlocked($blocage);
            $this->em->persist($tache);
            $this->em->flush();
        }catch (ORMException $e) {
            return array("success"=>false,"message"=>$e->getMessage());
        }

        return array("success"=>true,"message"=>"The task has been $statut");
    }
}