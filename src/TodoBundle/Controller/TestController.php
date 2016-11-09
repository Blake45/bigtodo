<?php


namespace TodoBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TestController extends Controller
{

    public function indexAction(Request $request) {


        return $this->render(
            'TodoBundle:Test:index.html.php',
            array(

            )
        );

    }

}