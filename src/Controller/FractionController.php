<?php

namespace App\Controller;

use App\Entity\Fraction;
use App\Form\FractionType;
use App\Repository\FractionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/fraction')]
class FractionController extends AbstractController
{
    #[Route('/', name: 'app_fraction_index', methods: ['GET'])]
    public function index(FractionRepository $fractionRepository): Response
    {
        return $this->render('fraction/index.html.twig', [
            'fractions' => $fractionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_fraction_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $fraction = new Fraction();
        $form = $this->createForm(FractionType::class, $fraction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($fraction);
            $entityManager->flush();

            return $this->redirectToRoute('app_fraction_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('fraction/new.html.twig', [
            'fraction' => $fraction,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_fraction_show', methods: ['GET'])]
    public function show(Fraction $fraction): Response
    {
        return $this->render('fraction/show.html.twig', [
            'fraction' => $fraction,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_fraction_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Fraction $fraction, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FractionType::class, $fraction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_fraction_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('fraction/edit.html.twig', [
            'fraction' => $fraction,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_fraction_delete', methods: ['POST'])]
    public function delete(Request $request, Fraction $fraction, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fraction->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($fraction);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_fraction_index', [], Response::HTTP_SEE_OTHER);
    }
}
