<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Entity\TypeReclamation;
use App\Form\TypeReclamationType;

use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use App\Repository\TypeReclamationRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\Routing\Annotation\Route;

class ReclamationController extends AbstractController
{
    #[Route('/reclamation', name: 'app_reclamation_index', methods: ['GET'])]
    public function index(ReclamationRepository $ReclamationRepository , TypeReclamationRepository $TypeReclamationRepository, Request $request): Response
    {
        $searchTerm = $request->query->get('q');
        $typeRec = $request->query->get('type_r');
        if ($searchTerm) {
            $reclamations = $ReclamationRepository->findBySearchTerm($searchTerm);
        } else if ($typeRec) {
            $typeReclamation = $TypeReclamationRepository->findOneBy(['type_r' => $typeRec]);
            $reclamations = $ReclamationRepository->findBy(['typeReclamation' => $typeReclamation], ['text_rec' => 'ASC']);
        } else {
            $reclamations = $ReclamationRepository->findBy([], ['text_rec' => 'ASC']);
        }
        $typeReclamations = $TypeReclamationRepository->findAll();
        return $this->render('reclamation/index.html.twig', [
            'controller_name' => 'ReclamationController',
            'reclamation' => $reclamations,
            'title' => 'Historique',
            'subtitle' => 'reclamation',
            'searchTerm' => $searchTerm,
            'typeReclamations' => $typeReclamations,
            'selectedType' => $typeRec
        ]);
    }

    #[Route('/reclamation/new', name: 'app_reclamation_new', methods: ['GET', 'POST'])]
    public function add(Request $request): Response
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
        $em->persist($reclamation);
        $em->flush();

            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reclamation/new.html.twig', [
            'title' => 'Ajouter',
            'subtitle' => 'reclamations',
            'controller_name' => 'ReclamationController',

            'form' => $form->createView(),
        ]);
    }

    #[Route('/reclamation/{id}', name: 'app_reclamation_show', methods: ['GET'])]
    public function show(Reclamation $reclamation): Response
    {
        return $this->render('reclamation/show.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }

    #[Route('/reclamation/{id}/edit', name: 'app_reclamation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reclamation $reclamation, ReclamationRepository $reclamationRepository): Response
    {
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamationRepository->save($reclamation, true);

            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    #[Route('/reclamation/{id}', name: 'app_reclamation_delete')]
    public function delete(Reclamation $reclamation): RedirectResponse
    {
            $em = $this->getDoctrine()->getManager();
        $em->remove($reclamation);
        $em->flush();
        

        return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
    }
}
