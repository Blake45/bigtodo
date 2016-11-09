<?php


namespace TodoBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TodoBundle\Entity\Projet;
use TodoBundle\Form\ProjetType;

class ProjetController extends Controller
{

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
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

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showProjetsAction(){

        $em = $this->getDoctrine()->getManager();

        $projetRepo = $em->getRepository("TodoBundle:Projet");
        $projets = $projetRepo->findAll();

        return $this->render("TodoBundle:Projet:list_in_header.html.twig",array(
           "projets"=>$projets
        ));

    }

    /**
     * Set the projet in session as current project
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function setProjetInSessionAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $projet = $em->getRepository("TodoBundle:Projet")->find($request->get('projet'));
        $session = $this->get('session');

        if(is_null($projet)){
            $session->getFlashBag()->add('error', "This project doesn't exist");
        }else{
            $session->set('current_project',$projet);
        }

        return $this->redirect($this->generateUrl("todo_homepage"));
    }

}