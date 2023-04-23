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


class EditerTypePosteController extends AbstractController
{

    #[Route('admin/type/post/{id}/edit', name: 'admin_edit_type')]
    public function edit(TypePublication $typ, Request $request): Response
    {
        $form=$this->createForm(TypePublicationType::class, $typ);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('admin_type_post'); //specific the name of the route
        }
        return $this->render('editTypePoste/index.html.twig', [
            'form2' => $form->createView(),
        ]);
    }

}
