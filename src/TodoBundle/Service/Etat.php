<?php
/**
 * Created by PhpStorm.
 * User: Thibaut
 * Date: 03/11/2016
 * Time: 14:33
 */

namespace TodoBundle\Service;


use Doctrine\ORM\EntityManagerInterface;

class Etat
{
    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    public function initTableEtat() {

        $etatRepo = $this->em->getRepository("TodoBundle:Etat");
        $etatRepo->initEtats();

    }

}