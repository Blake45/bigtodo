<?php
/**
 * Created by PhpStorm.
 * User: tleclere
 * Date: 20/09/2016
 * Time: 17:02
 */

namespace TodoBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TodoBundle\Entity\Projet;
use TodoBundle\Form\ProjetType;

class ProjetController extends Controller
{

    public function addProjetAction(Request $request){

        $projet = new Projet();
        $form = $this->createForm(new ProjetType(),$projet);

        $form->handleRequest($request);
        if($form->isValid()){

            if( $this->get('todo.handle_projet')->saveProjet($projet,$request) ){
                return $this->redirect($this->generateUrl("todo_homepage"));
            }
        }

        return $this->render("TodoBundle:Projet:projet.html.twig",array(
           'form'=>$form->createView()
        ));

    }

    public function showProjetsAction(){

        $em = $this->getDoctrine()->getManager();

        $projetRepo = $em->getRepository("TodoBundle:Projet");
        $projets = $projetRepo->findAll();

        return $this->render("TodoBundle:Projet:list_in_header.html.twig",array(
           "projets"=>$projets
        ));

    }

}