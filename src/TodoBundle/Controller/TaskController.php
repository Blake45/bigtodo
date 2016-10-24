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
        $etatRepo = $em->getRepository("TodoBundle:EtatTache");
        $id_task = $request->get('tache');
        $tache = $em->getRepository("TodoBundle:Tache")->find($id_task);
        $etat_precedent = $tache->getEtat();
        $nom_etat = $this->get('todo.handle_tache')->getEtatByColonne($request->get("etat"));
        $etat_nouveau = $etatRepo->findOneBy(array("nom"=>$nom_etat));
        $tache->setEtat($etat_nouveau);
        $em->persist($tache);
        $em->flush();

        return new JsonResponse(array("success"=>true));
    }

}