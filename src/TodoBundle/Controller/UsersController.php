<?php
/**
 * Created by PhpStorm.
 * User: Thibaut
 * Date: 08/11/2016
 * Time: 17:28
 */

namespace TodoBundle\Controller;

use UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class UsersController extends Controller
{

    /**
     * @return array
     * @View()
     */
    public function getUsersAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('UserBundle:User')->findAll();

        return array('users' => $users);
    }

    /**
     * @param User $user
     * @return array
     * @View()
     * @ParamConverter("user", class="UserBundle:User")
     */
    public function postUserAction(User $user)
    {
        return array('user' => $user);
    }

}