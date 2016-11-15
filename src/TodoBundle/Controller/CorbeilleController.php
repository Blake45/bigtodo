<?php

namespace TodoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CorbeilleController extends Controller
{

    /**
     * Display the corbeille page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function corbeilleAction()
    {
        $taches = $this->get('todo_corbeille')->getAllTasks();

        return $this->render('TodoBundle:Corbeille:corbeille.html.twig', array(
            "taches"=>$taches
        ));
    }

    /**
     * @param $idtache
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($idtache)
    {
        $this->get('todo_corbeille')->deleteTask($idtache);

        return $this->redirect($this->generateUrl("todo_corbeille"));
    }

    /**
     * @param $idtache
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function reopenAction($idtache) {

        $this->get('todo_corbeille')->reopenTask($idtache);

        return $this->redirect($this->generateUrl("todo_corbeille"));

    }

}
