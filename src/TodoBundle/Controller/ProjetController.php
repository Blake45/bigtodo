<?php
/**
 * Created by PhpStorm.
 * User: tleclere
 * Date: 20/09/2016
 * Time: 17:02
 */

namespace TodoBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProjetController extends Controller
{

    public function addProjetAction(){

        return $this->render("TodoBundle:Projet:projet.html.twig",array(
           'form'=>""
        ));

    }

}