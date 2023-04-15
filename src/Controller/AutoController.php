<?php

namespace App\Controller;

use App\Entity\Autos;
use App\Form\AutoFormType;
use App\Repository\AutosRepository;
use Doctrine\ORM\EntityManagerInterface;
//use Doctrine\Persistence\ManagerRegistry;
//use http\Env\Request;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AutoController extends AbstractController
{
    #[Route('/auto', name: 'app_auto')]
    public function index(AutosRepository $autosRepository)
    {
        $auto = $autosRepository->findAll();

        return $this->render('auto/index.html.twig', [
            'auto' =>$auto,
        ]);
    }


    #[Route('/update/{id}', name: 'update')]
    public function update(AutosRepository $autosRepository, Autos $autoClass , EntityManagerInterface $entityManager, Request $request)
    {
        $id = $autoClass->getId();
        $auto = new Autos();
        $auto->$autosRepository->find($id);
        $form = $this->createForm(AutoFormType::class, $auto);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $auto = $form->getData();
            $entityManager->persist($auto);
            $entityManager->flush($auto);
//            $this->redirectToRoute('home');
        }
        return $this->renderForm('update.html.twig', [
            'form' => $form
        ]);



    }

    #[Route('/insert/{id}')]
    public function insert(Autos $autoCLass, EntityManagerInterface $entityManager, AutosRepository $autosRepository, Request $request)
    {
//        $id = $autoCLass->getId();
        $auto = new Autos();
//        $auto = $autosRepository->find();
        $form = $this->createForm(AutoFormType::class , $auto);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $auto = $form->getData();
            $entityManager->persist($auto);
            $entityManager->flush($auto);
            $this->addFlash('warning', 'Rij toegevoegd');
//            $this->redirectToRoute('home');
        }
        return $this->renderForm('insert.html.twig', [
            'form'=> $form
        ]);
    }


    #[Route('/details/{id}')]
    public function details(AutosRepository $autosRepository, Autos $autoClass)
    {
        $id = $autoClass->getId();
        $auto= $autosRepository->find($id);
        return $this->render('details.html.twig', [
            'auto' => $auto
        ]);
    }


    #[Route('/delete/{id}')]
    public function delete(AutosRepository $autosRepository,  EntityManagerInterface $entityManager, $id)
    {
        $auto = $autosRepository->find($id);
        $entityManager->remove($auto);

        $entityManager->flush($auto);

    }


}
