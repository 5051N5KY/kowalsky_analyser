<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use League\Flysystem\FilesystemOperator;

class HomeController extends AbstractController
{
    public function __construct(private FilesystemOperator $mainStorage)
    {
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $objects = $this->getPhotos();
   
        return $this->render('home/index.html.twig', ['items' => $objects]);
    }

    public function getPhotos(): array
    {
        $files = $this->mainStorage->listContents('objects/', 'files')->toArray();
        $paths = [];
        $storagePath = 'storage/';
        foreach ($files as $file) {
            $paths[] = $storagePath.$file['path'];
        }
        
        return $paths;
    }
}
