<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Entity\User;


class UserController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function index() : Response
    {
        return $this->render('home/index.html.twig', ['title' => 'Join our family', 'subtitle' => 'CoRide',]); 
    }

    /**
     * @Route("/sign-up", name="sign-upssss")
     */
    public function signupView(UserPasswordEncoderInterface $passwordEncoder)
    {
        return new Response('User/sign-up.html.twig');
    }
}
