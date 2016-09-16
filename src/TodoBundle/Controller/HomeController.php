<?php

namespace TodoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{

    public function indexAction(){

        return $this->render("TodoBundle:Home:index.html.twig",array(

        ));

    }

}
