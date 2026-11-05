<?php

namespace App\Controller;

use App\Entity\Benevoles;
use App\Form\BenevolesType;
use App\Repository\BenevolesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/benevoles')]
final class BenevolesController extends AbstractController
{
    #[Route(name: 'app_benevoles_index', methods: ['GET'])]
    public function index(BenevolesRepository $benevolesRepository): Response
    {
        return $this->render('benevoles/index.html.twig', [
            'benevoles' => $benevolesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_benevoles_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $benevole = new Benevoles();
        $form = $this->createForm(BenevolesType::class, $benevole);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($benevole);
            $entityManager->flush();

            return $this->redirectToRoute('app_benevoles_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('benevoles/new.html.twig', [
            'benevole' => $benevole,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_benevoles_show', methods: ['GET'])]
    public function show(Benevoles $benevole): Response
    {
        return $this->render('benevoles/show.html.twig', [
            'benevole' => $benevole,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_benevoles_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Benevoles $benevole, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BenevolesType::class, $benevole);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_benevoles_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('benevoles/edit.html.twig', [
            'benevole' => $benevole,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_benevoles_delete', methods: ['POST'])]
    public function delete(Request $request, Benevoles $benevole, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$benevole->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($benevole);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_benevoles_index', [], Response::HTTP_SEE_OTHER);
    }
}
