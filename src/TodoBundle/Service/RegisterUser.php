<?php
/**
 * Created by PhpStorm.
 * User: tleclere
 * Date: 23/09/2016
 * Time: 17:21
 */

namespace TodoBundle\Service;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Util\SecureRandomInterface;
use UserBundle\Entity\User;

class RegisterUser
{
    private $em;

    private $saltGenerator;

    private $passwordEncoder;

    public function __construct(SecureRandomInterface $saltGenerator, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $em){
        $this->em = $em;
        $this->saltGenerator = $saltGenerator;
        $this->passwordEncoder = $passwordEncoder;
    }


    public function registerUser(User $user,Request $request){

        //$user->addPermissions('ROLE_PLAYER');

        try {
            $user->setSalt(sha1($this->saltGenerator->nextBytes(128)));
            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));
            $this->em->persist($user);
            $this->em->flush();

            $request->getSession()->getFlashBag()->add('success',"Congrats! You've just signed up");
            return true;

        }catch (ORMException $e){
            $request->getSession()->getFlashBag()->add('error',$e->getMessage());
            return true;
        }

    }
}