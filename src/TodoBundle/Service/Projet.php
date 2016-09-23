<?php


namespace TodoBundle\Service;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\Request;
use TodoBundle\Entity\Projet as EntityProjet;

/**
 * Class Projet to handle operation on projet entity
 * @package TodoBundle\Service
 */
class Projet
{
    private $em;

    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }

    /**
     * Save a new project in database
     * @param EntityProjet $projet
     * @param Request $request
     */
    public function saveProjet(EntityProjet $projet, Request $request){

        try {

            $this->em->persist($projet);
            $this->em->flush();

            $request->getSession()->getFlashBag()->add('success',"Project ".$projet->getNom()." has been saved");
            return true;

        }catch (ORMException $e){

            $request->getSession()->getFlashBag()->add('error',$e->getMessage());
            return false;

        }
    }
}