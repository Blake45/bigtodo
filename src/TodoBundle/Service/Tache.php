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
use TodoBundle\Entity\Tache as EntityTache;

class Tache
{
    private $em;

    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }

    public function saveTache(EntityTache $tache, Request $request){

        try{
            $tache->setDateCreation(new \DateTime());
            $this->em->persist($tache);
            $this->em->flush();

            $request->getSession()->getFlashBag()->add('success',"Project ".$tache->getNom()." has been added");
            return true;

        }catch (ORMException $e){
            $request->getSession()->getFlashBag()->add('error',$e->getMessage());
            return false;
        }

    }

    public function getTachesByProjet($id_projet = null){

        $tacheRepository = $this->em->getRepository("TodoBundle:Tache");
        if($id_projet){
            //todo get taches by project
            $taches = null;
        }else{
            $taches = $tacheRepository->findAll();
        }

        return $taches;

    }
}