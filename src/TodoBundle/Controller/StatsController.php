<?php

namespace TodoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StatsController extends Controller
{
    /**
     * todo
     * Display all the ended tasks with stats on them
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function endedTaskAction()
    {
        $current_project = $this->get('session')->get('current_project');
        $endedTasks = $this->get('todo_stats')->getAllEndedTasks($current_project);
        $veracity = $this->get('todo_stats')->getVeracityTasks($endedTasks);
        $average = $this->get('todo_stats')->getAverageTimeByTasks($endedTasks);


        return $this->render('TodoBundle:Stats:endedTask.html.twig', array(
            "endedTasks"=>$endedTasks,
            "veracity"=>$veracity,
            "projet"=>$current_project->getNom(),
            "average"=>$average
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
