<?php
/**
 * Created by PhpStorm.
 * User: Thibaut
 * Date: 15/11/2016
 * Time: 14:18
 */

namespace TodoBundle\Service;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Corbeille
{
    private $em;
    private $container;

    public function __construct(EntityManagerInterface $em, ContainerInterface $container) {
        $this->em = $em;
        $this->container = $container;
    }

    /**
     * Return all tasks in the Corbeille
     * @return array
     */
    public function getAllTasks() {

        return $this->em->getRepository("TodoBundle:Tache")->findBy(array("encorbeille"=>true));

    }


    /**
     * Delete the task
     * @param $id
     */
    public function deleteTask($id) {

        $tache = $this->em->getRepository("TodoBundle:Tache")->find($id);

        if(is_null($tache)){
            $this->container->get('session')->getFlashBag()->add('error', 'The task does not exist');
        }

        try {
            $this->em->remove($tache);
            $this->em->flush();
            $this->container->get('session')->getFlashBag()->add('success', 'The task has been deleted with all the informations linked to it');
        }catch (ORMException $e) {
            $this->container->get('session')->getFlashBag()->add('error', $e->getMessage());
        }

    }


    /**
     * Reopen the task
     * @param $id
     */
    public function reopenTask($id) {

        $tache = $this->em->getRepository("TodoBundle:Tache")->find($id);

        if(is_null($tache)){
            $this->container->get('session')->getFlashBag()->add('error', 'The task does not exist');
        }

        try {
            $tache->setEncorbeille(false);
            $this->em->persist($tache);
            $this->em->flush();
            $this->container->get('session')->getFlashBag()->add('success', 'The task has been removed from the trash and reopened');
        }catch (ORMException $e) {
            $this->container->get('session')->getFlashBag()->add('error', $e->getMessage());
        }

    }
}