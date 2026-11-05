<?php

namespace App\Controller;

use App\Entity\Techniques;
use App\Form\TechniquesType;
use App\Repository\TechniquesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/techniques')]
final class TechniquesController extends AbstractController
{
    #[Route(name: 'app_techniques_index', methods: ['GET'])]
    public function index(TechniquesRepository $techniquesRepository): Response
    {
        return $this->render('techniques/index.html.twig', [
            'techniques' => $techniquesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_techniques_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $technique = new Techniques();
        $form = $this->createForm(TechniquesType::class, $technique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($technique);
            $entityManager->flush();

            return $this->redirectToRoute('app_techniques_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('techniques/new.html.twig', [
            'technique' => $technique,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_techniques_show', methods: ['GET'])]
    public function show(Techniques $technique): Response
    {
        return $this->render('techniques/show.html.twig', [
            'technique' => $technique,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_techniques_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Techniques $technique, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TechniquesType::class, $technique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_techniques_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('techniques/edit.html.twig', [
            'technique' => $technique,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_techniques_delete', methods: ['POST'])]
    public function delete(Request $request, Techniques $technique, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$technique->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($technique);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_techniques_index', [], Response::HTTP_SEE_OTHER);
    }
}
