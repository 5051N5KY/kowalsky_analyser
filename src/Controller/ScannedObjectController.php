<?php

namespace App\Controller;

use App\Entity\ScannedObject;
use App\Form\ScannedObjectType;
use App\Repository\ScannedObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/scanned/object')]
class ScannedObjectController extends AbstractController
{
    #[Route('/', name: 'app_scanned_object_index', methods: ['GET'])]
    public function index(ScannedObjectRepository $scannedObjectRepository): Response
    {
        return $this->render('scanned_object/index.html.twig', [
            'scanned_objects' => $scannedObjectRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_scanned_object_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $scannedObject = new ScannedObject();
        $form = $this->createForm(ScannedObjectType::class, $scannedObject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($scannedObject);
            $entityManager->flush();

            return $this->redirectToRoute('app_scanned_object_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('scanned_object/new.html.twig', [
            'scanned_object' => $scannedObject,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_scanned_object_show', methods: ['GET'])]
    public function show(ScannedObject $scannedObject): Response
    {
        return $this->render('scanned_object/show.html.twig', [
            'scanned_object' => $scannedObject,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_scanned_object_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ScannedObject $scannedObject, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ScannedObjectType::class, $scannedObject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_scanned_object_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('scanned_object/edit.html.twig', [
            'scanned_object' => $scannedObject,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_scanned_object_delete', methods: ['POST'])]
    public function delete(Request $request, ScannedObject $scannedObject, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$scannedObject->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($scannedObject);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_scanned_object_index', [], Response::HTTP_SEE_OTHER);
    }
}
