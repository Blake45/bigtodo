<?php


namespace TodoBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TodoBundle\Entity\Tache;
use TodoBundle\Form\TacheType;

class TaskController extends Controller
{

    public function new_taskPostAction(Request $request){

        $task = new Tache();
        $form = $this->createForm(new TacheType(),$task);

        $form->handleRequest($request);
        if($form->isValid()){

        }

        return $this->redirect($this->generateUrl(""));

    }

}