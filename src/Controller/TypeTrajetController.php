<?php

namespace App\Controller;

use App\Entity\TypeTrajet;
use App\Form\TypeTrajetType;
use App\Repository\TypeTrajetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TypeTrajetController extends AbstractController
{
    #[Route('/type', name: 'app_type_trajet_index', methods: ['GET'])]
    public function index(TypeTrajetRepository $typeTrajetRepository): Response
    {
        return $this->render('type_trajet/index.html.twig', [
            'type_trajets' => $typeTrajetRepository->findAll(),
        ]);
    }

  
    #[Route('/new', name: 'app_type_trajet_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TypeTrajetRepository $typeTrajetRepository): Response
    {
        $typeTrajet = new TypeTrajet();
        $form = $this->createForm(TypeTrajetType::class, $typeTrajet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeTrajetRepository->save($typeTrajet, true);

            return $this->redirectToRoute('app_type_trajet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_trajet/new.html.twig', [
            'type_trajet' => $typeTrajet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_trajet_show', methods: ['GET'])]
    public function show(TypeTrajet $typeTrajet): Response
    {
        return $this->render('type_trajet/show.html.twig', [
            'type_trajet' => $typeTrajet,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_type_trajet_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeTrajet $typeTrajet, TypeTrajetRepository $typeTrajetRepository): Response
    {
        $form = $this->createForm(TypeTrajetType::class, $typeTrajet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeTrajetRepository->save($typeTrajet, true);

            return $this->redirectToRoute('app_type_trajet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_trajet/edit.html.twig', [
            'type_trajet' => $typeTrajet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_trajet_delete', methods: ['POST'])]
    public function delete(Request $request, TypeTrajet $typeTrajet, TypeTrajetRepository $typeTrajetRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeTrajet->getId(), $request->request->get('_token'))) {
            $typeTrajetRepository->remove($typeTrajet, true);
        }

        return $this->redirectToRoute('app_type_trajet_index', [], Response::HTTP_SEE_OTHER);
    }
}
