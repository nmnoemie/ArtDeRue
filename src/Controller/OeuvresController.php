<?php

namespace App\Controller;

use App\Entity\Oeuvres;
use App\Entity\Lieux;      // <-- AJOUT IMPORTANT
use App\Entity\Technique;  // <-- AJOUT IMPORTANT
use App\Form\OeuvresType;
use App\Repository\OeuvresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/oeuvres')]
final class OeuvresController extends AbstractController
{
    #[Route(name: 'app_oeuvres_index', methods: ['GET'])]
    public function index(OeuvresRepository $oeuvresRepository): Response
    {
        return $this->render('oeuvres/index.html.twig', [
            'oeuvres' => $oeuvresRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_oeuvres_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $oeuvre = new Oeuvres();
        $form = $this->createForm(OeuvresType::class, $oeuvre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            // 1. Gestion du nouveau lieu
            $nouveauLieuNom = $form->get('nouveauLieu')->getData();
            if ($nouveauLieuNom) {
                $nouveauLieu = new Lieux();
                $nouveauLieu->setNom($nouveauLieuNom);
                $entityManager->persist($nouveauLieu);
                $oeuvre->setLieux($nouveauLieu); // Attention: setLieux ou setLieu selon votre entité
            }

            // 2. Gestion de la nouvelle technique
            $nouvelleTechniqueNom = $form->get('nouvelleTechnique')->getData();
            if ($nouvelleTechniqueNom) {
                $nouvelleTechnique = new Technique(); // <-- CORRECTION: Majuscule à Technique
                $nouvelleTechnique->setNom($nouvelleTechniqueNom);
                $entityManager->persist($nouvelleTechnique);
                $oeuvre->setTechnique($nouvelleTechnique);
            }

            // 3. Enregistrement de l'œuvre
            $entityManager->persist($oeuvre);
            $entityManager->flush();

            return $this->redirectToRoute('app_oeuvres_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('oeuvres/new.html.twig', [
            'oeuvre' => $oeuvre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_oeuvres_show', methods: ['GET'])]
    public function show(Oeuvres $oeuvre): Response
    {
        return $this->render('oeuvres/show.html.twig', [
            'oeuvre' => $oeuvre,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_oeuvres_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Oeuvres $oeuvre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OeuvresType::class, $oeuvre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_oeuvres_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('oeuvres/edit.html.twig', [
            'oeuvre' => $oeuvre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_oeuvres_delete', methods: ['POST'])]
    public function delete(Request $request, Oeuvres $oeuvre, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$oeuvre->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($oeuvre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_oeuvres_index', [], Response::HTTP_SEE_OTHER);
    }
}