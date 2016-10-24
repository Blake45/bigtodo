<?php

namespace TodoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TodoBundle\Entity\Etat;
use TodoBundle\Form\EtatType;

class EtatController extends Controller
{
    /**
     * Create Etat
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createEtatAction(Request $request) {

        $etat = new Etat();
        $form = $this->createForm(new EtatType(),$etat);

        $form->handleRequest($request);
        if($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($etat);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success',"Etat ".$etat->getNom()." has been saved");

        }

        return $this->render('TodoBundle:Etat:createEtat.html.twig', array(
            'form'=>$form->createView()
        ));
    }

}
