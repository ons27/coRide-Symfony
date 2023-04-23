<?php

namespace App\Controller;

use App\Entity\TypePublication;
use App\Form\TypePublicationType;
use App\Repository\TypePublicationRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class TypePostEditController extends AbstractController
{
    #[Route('admin/type/post/{id}/edit', name: 'admin_edit_type')]
    public function edit(TypePublication $typ, Request $request): Response
    {
        $form2=$this->createForm(TypePublicationType::class, $typ);
        $form2->handleRequest($request);
        if($form2->isSubmitted()){
            $em2 = $this->getDoctrine()->getManager();
            $em2->flush();
            return $this->redirectToRoute('admin_type_post'); //specific the name of the route
        }
        return $this->render('type_post_edit/index.html.twig', [
            'form2' => $form2->createView(),
        ]);
    }

}
