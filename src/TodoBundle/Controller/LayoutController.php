<?php
/**
 * Created by PhpStorm.
 * User: tleclere
 * Date: 16/09/2016
 * Time: 17:12
 */

namespace TodoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use TodoBundle\Entity\Tache;
use TodoBundle\Form\TacheType;

class LayoutController extends Controller
{

    public function renderTaskAction(){

        $form = $this->createForm(new TacheType(),new Tache(),array(
            "action"=>$this->generateUrl("todo_add_new_task")
        ));
        return $this->render("TodoBundle:Modal:new_task.html.twig",array(
           'form'=>$form->createView()
        ));

    }

}