<?php
/**
 * Created by PhpStorm.
 * User: tleclere
 * Date: 23/09/2016
 * Time: 15:25
 */

namespace UserBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;
use UserBundle\Form\UserType;

class SecurityController extends Controller
{

    public function loginAction(){

        $utils = $this->get('security.authentication_utils');

        return $this->render("UserBundle:Security:login.html.twig",array(
            'last_username'=>$utils->getLastUsername(),
            'error'=>$utils->getLastAuthenticationError(),
        ));

    }

    public function loginCheckAction(){}

    public function logoutAction(){}


    public function registerAction(Request $request){

        $user = new User();
        $form = $this->createForm(new UserType(),$user);

        $form->handleRequest($request);
        if($form->isValid()){
            if( $this->get('todo.user_register')->registerUser($user,$request) ){
                return $this->redirect($this->generateUrl("todo_homepage"));
            }
        }

        return $this->render("UserBundle:Security:register.html.twig",array(
            "form"=>$form->createView()
        ));

    }

}