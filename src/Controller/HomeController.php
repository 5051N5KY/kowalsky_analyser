<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use League\Flysystem\FilesystemOperator;

class HomeController extends AbstractController
{
    public function __construct(private FilesystemOperator $defaultStorage)
    {
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        /*$this->defaultStorage->write('default.txt', 'Test');
        //dd($this->defaultStorage->listContents('', 100)->toArray());
        return $this->render('home/index.html.twig', [
            'controller_name' => $this->defaultStorage->read('default.txt'),
        ]);*/
        $items = [
            ['column1' => 'Item 1', 'column2' => 'Value 1'],
            ['column1' => 'Item 2', 'column2' => 'Value 2'],
            // Dodaj więcej pozycji w miarę potrzeby
        ];

        return $this->render('home/index.html.twig', ['items' => $items]);
    }
}
