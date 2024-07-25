<?php

namespace App\Controller;

use App\Entity\ScannedObject;
use App\Form\ScannedObjectType;
use App\Form\ScannedObjectLogType;
use App\Repository\ScannedObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use League\Flysystem\FilesystemOperator;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use TCPDF;
use Imagick;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;

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
    public function new(Request $request, EntityManagerInterface $entityManager, FilesystemOperator $mainStorage): Response
    {
        $scannedObject = new ScannedObject();
        $form = $this->createForm(ScannedObjectType::class, $scannedObject);
        $form->handleRequest($request);
        $photoPath = $request->request->get('photo_path');
        $scannedObject->setPhotoPath($photoPath);

        if ($form->isSubmitted() && $form->isValid()) {
            $filePathWithoutPrefix = str_replace(HomeController::STORAGE_PREFIX, '', $photoPath);
            $photoName = str_replace('/objects/', '', $filePathWithoutPrefix);
            $scannedPath = 'scanned/'.$photoName;

            $mainStorage->move($filePathWithoutPrefix, $scannedPath);

            $scannedObject->setPhotoPath(HomeController::STORAGE_PREFIX.$scannedPath);

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
        if ($this->isCsrfTokenValid('delete' . $scannedObject->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($scannedObject);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_scanned_object_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/addLog', name: 'app_scanned_object_add_log', methods: ['GET', 'POST'])]
    public function addLog(Request $request, ScannedObject $scannedObject, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ScannedObjectLogType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $scannedObject->addLog((string) $data['text'], $data['shper']?->getNickname());
            $entityManager->flush();

            return $this->redirectToRoute('app_scanned_object_show', ['id' => $scannedObject->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('scanned_object/edit.html.twig', [
            'scanned_object' => $scannedObject,
            'form' => $form,
        ]);
    }


    #[Route('/{id}/generate', name: 'app_scanned_object_generate', methods: ['GET'])]
    public function generate(ScannedObject $scannedObject, FilesystemOperator $mainStorage, ParameterBagInterface $parameterBag): RedirectResponse
    {
        $pdf = new TCPDF();
        $pdf->AddPage();
        $photoPath = str_replace(HomeController::STORAGE_PREFIX, '', $scannedObject->getPhotoPath());

        $photoBasePath = $parameterBag->get('kernel.project_dir') . '/var' . $scannedObject->getPhotoPath();

        try{
            $photo = $mainStorage->read($photoPath);
        }catch(Exception $e){
            nl2br($e->getMessage());
            return $this->redirectToRoute('app_scanned_object_index', [], Response::HTTP_SEE_OTHER);
        }
        

        $base64ImageSrc = 'data:image/' . $mainStorage->mimeType($photoPath) . ';base64,' . base64_encode($photo);

        $html = $this->renderView('scanned_object/pdf/pdf.html.twig', [
            'scannedObject' => $scannedObject,
            'photob64' => $base64ImageSrc
        ]);

        $pdf->SetFont('dejavusans', '', 8);

        $pdf->writeHTML($html);

        $pdf->Output('example_001.pdf', 'I');
        die;
    }
}
