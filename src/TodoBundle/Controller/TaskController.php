<?php


namespace TodoBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use TodoBundle\Entity\Tache;
use TodoBundle\Form\TacheType;

class TaskController extends Controller
{

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function new_taskPostAction(Request $request){

        $task = new Tache();
        $form = $this->createForm(new TacheType(),$task);

        $form->handleRequest($request);
        if($form->isValid()){
            $this->get('todo.handle_tache')->saveTache($task, $request);
        }

        return $this->redirect($this->generateUrl("todo_homepage"));

    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deplacementTacheAction(Request $request) {

        $em = $this->getDoctrine()->getManager();

        $id_task = $request->get('tache');
        $tache = $em->getRepository("TodoBundle:Tache")->find($id_task);

        $etat_nouveau = $this->get('todo.handle_tache')->getEtatByColonne($request->get("etat"));

        return new JsonResponse(
            $this->get('todo.handle_tache')->changeEtatTache($tache,$etat_nouveau)
        );
    }


    public function taskOverAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $tache = $em->getRepository("TodoBundle:Tache")->find($request->get('tache'));

        if(is_null($tache) || !$etat = $tache->getEtat() || $tache->getEtat()->getNom() != "Terminé" ) {
            return new JsonResponse(array("error"=>"Can't do the process to this task, please refresh your page"));
        }

        //todo requete pour calculer le temps passé sur la tache
        $tempsPasser = $this->get('todo.handle_tache')->getSpentTime($tache,$etat);

        $retour = $this->get('todo.handle_tache')->setTempsPasserOnTask($tache,$tempsPasser);

        return new JsonResponse($retour);
    }

}