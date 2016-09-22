<?php


namespace TodoBundle\Service;


use Doctrine\ORM\EntityManagerInterface;
use TodoBundle\Entity\Projet as EntityProjet;

class Projet
{
    private $em;

    public function __construct(EntityManagerInterface $em){

        $this->em = $em;

    }

    public function saveProjet(EntityProjet $projet){

        $this->em->persist($projet);
        $this->em->flush();

    }
}