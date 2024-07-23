<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use League\Flysystem\FilesystemOperator;
use Symfony\Component\HttpFoundation\JsonResponse;

class HomeController extends AbstractController
{
    const STORAGE_PREFIX = 'storage/';

    public function __construct(private FilesystemOperator $mainStorage)
    {
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $objects = $this->getPhotos();
        return $this->render('home/index.html.twig', ['items' => $objects]);
    }

    #[Route('/deleteFile', name: 'delete_file', methods: ['POST'])]
    public function deleteFile(Request $request): JsonResponse
    {
        $filePath = $request->request->get('path');
        $filePathWithoutPrefix = str_replace(self::STORAGE_PREFIX, '', $filePath);

        try {
            if ($this->mainStorage->fileExists($filePathWithoutPrefix)) {
                $this->mainStorage->delete($filePathWithoutPrefix);
                return new JsonResponse(['status' => 'success'], Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            return new JsonResponse(['status' => 'error', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse(['status' => 'error', 'message' => 'File not found'], Response::HTTP_NOT_FOUND);
    }

    private function getPhotos(): array
    {
        $files = $this->mainStorage->listContents('objects/', 'files')->toArray();
        $paths = [];

        foreach ($files as $file) {
            $paths[] = self::STORAGE_PREFIX . $file['path'];
        }
        return $paths;
    }
}
