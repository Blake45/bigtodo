<?php

namespace TodoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use TodoBundle\Entity\ProjetRepository;

class HomeController extends Controller
{

    public function indexAction(){

        $taches = $this->get('todo.handle_tache')->getTachesByProjet();

        return $this->render("TodoBundle:Home:index.html.twig",array(
            "taches"=>$taches,
            "colonnes"=>array("a_faire","en_cours","finis","en_attente")
        ));

    }

}
