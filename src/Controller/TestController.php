<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    
    public function index(): Response
    {
        $tabs=[1,2,3,4,5,6];
        $bool=true;
        //renvoyer une page html a pertir du templates (AbstractController)
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
            'tabs' => $tabs,
            'bool' => $bool,
        ]);
    }
}
