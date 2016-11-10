<?php

namespace TodoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StatsController extends Controller
{
    /**
     * Display all the ended tasks with stats on them
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function endedTaskAction()
    {

        /**
         * todo
         * get all ended tasks by project or not
         * rapport entre temps prévu et temps réel
         * nombre de tache
         * rapport de complexité des taches
         * nombre de user sur les taches par projet ou pas
         */
        $current_project = $this->get('session')->get('current_project');
        $endedTasks = $this->get('todo_stats')->getAllEndedTasks($current_project);

        return $this->render('TodoBundle:Stats:endedTask.html.twig', array(
            "endedTasks"=>$endedTasks
        ));
    }

    public function projectAction($projet, $id_projet)
    {
        return $this->render('TodoBundle:Stats:project.html.twig', array(
                // ...
        ));
    }

    public function developperAction($iddev)
    {
        return $this->render('TodoBundle:Stats:developper.html.twig', array(
                // ...
        ));
    }

}
