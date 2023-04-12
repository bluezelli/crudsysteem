<?php

namespace App\Controller;

use App\Repository\AutosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AutoController extends AbstractController
{
    #[Route('/auto', name: 'app_auto')]
    public function index(AutosRepository $autosRepository): Response
    {
        $auto = $autosRepository->findAll();

        return $this->render('auto/index.html.twig', [
            'auto' =>$auto,
        ]);
    }
}
