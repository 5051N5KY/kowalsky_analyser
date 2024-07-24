<?php

namespace App\Controller;

use App\Entity\Shperacze;
use App\Form\ShperaczeType;
use App\Repository\ShperaczeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/shperacze')]
class ShperaczeController extends AbstractController
{
    #[Route('/', name: 'app_shperacze_index', methods: ['GET'])]
    public function index(ShperaczeRepository $shperaczeRepository): Response
    {
        return $this->render('shperacze/index.html.twig', [
            'shperaczes' => $shperaczeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_shperacze_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $shperacze = new Shperacze();
        $form = $this->createForm(ShperaczeType::class, $shperacze);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($shperacze);
            $entityManager->flush();

            return $this->redirectToRoute('app_shperacze_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('shperacze/new.html.twig', [
            'shperacze' => $shperacze,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_shperacze_show', methods: ['GET'])]
    public function show(Shperacze $shperacze): Response
    {
        return $this->render('shperacze/show.html.twig', [
            'shperacze' => $shperacze,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_shperacze_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Shperacze $shperacze, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ShperaczeType::class, $shperacze);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_shperacze_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('shperacze/edit.html.twig', [
            'shperacze' => $shperacze,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_shperacze_delete', methods: ['POST'])]
    public function delete(Request $request, Shperacze $shperacze, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$shperacze->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($shperacze);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_shperacze_index', [], Response::HTTP_SEE_OTHER);
    }
}
