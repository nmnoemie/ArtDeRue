<?php

namespace App\Controller;

use App\Entity\Artistes;
use App\Form\ArtistesType;
use App\Repository\ArtistesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/artistes')]
final class ArtistesController extends AbstractController
{
    #[Route(name: 'app_artistes_index', methods: ['GET'])]
    public function index(ArtistesRepository $artistesRepository): Response
    {
        return $this->render('artistes/index.html.twig', [
            'artistes' => $artistesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_artistes_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $artiste = new Artistes();
        $form = $this->createForm(ArtistesType::class, $artiste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($artiste);
            $entityManager->flush();

            return $this->redirectToRoute('app_artistes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('artistes/new.html.twig', [
            'artiste' => $artiste,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_artistes_show', methods: ['GET'])]
    public function show(Artistes $artiste): Response
    {
        return $this->render('artistes/show.html.twig', [
            'artiste' => $artiste,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_artistes_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Artistes $artiste, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArtistesType::class, $artiste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_artistes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('artistes/edit.html.twig', [
            'artiste' => $artiste,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_artistes_delete', methods: ['POST'])]
    public function delete(Request $request, Artistes $artiste, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$artiste->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($artiste);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_artistes_index', [], Response::HTTP_SEE_OTHER);
    }
}
