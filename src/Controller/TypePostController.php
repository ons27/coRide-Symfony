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


class TypePostController extends AbstractController
{

    #[Route('admin/type/post', name: 'admin_type_post')]
    public function index(TypePublicationRepository $TypePosteRepository,Request $request): Response
    {
        $typePoste=new TypePublication();
        $form=$this->createForm(TypePublicationType::class, $typePoste);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($typePoste);
            $em->flush();
            return $this->redirectToRoute('admin_type_post'); //specific the name of the route
        }
        return $this->render('type_post/index.html.twig', [
            'form'=> $form->createView(),
            'typesPostes' => $TypePosteRepository->findAll(),

        ]);
    }
    #[Route('admin/type/post/{id}/delete', name: 'admin_delete_type')]
    public function delete(TypePublication $TypePublication): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($TypePublication);
        $em->flush();

        return $this->redirectToRoute('admin_type_post'); //specific the name of the route
    }
 /*
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
        return $this->render('type_post/index.html.twig', [
            'form2' => $form2->createView(),
        ]);
    }
*/
}
