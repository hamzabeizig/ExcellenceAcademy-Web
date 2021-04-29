<?php

namespace App\Controller;

use App\Repository\AssiduiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Assiduite;
use App\Form\AssiduiteType;
use App\Message\GenerateReport;

class AssiduiteController extends AbstractController
{
    /**
     * @Route("/assiduite", name="assiduite_index")
     */
    public function index(AssiduiteRepository $assiduiteRepository): Response
    {
        $assiduite= $assiduiteRepository->findAll();

        return $this->render('enseignant/assiduite/index.html.twig', [
            'assiduite' =>$assiduite
        ]);
    }
    /**
     * @Route("/assiduite/new", name="assiduite_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $assiduite = new Assiduite();
        $form = $this->createForm(AssiduiteType::class,$assiduite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($assiduite);
            $entityManager->flush();

            if ($assiduite && $assiduite->getValeur()=="A"){

                $this->dispatchMessage(new GenerateReport($assiduite->getId(), '+21650683952'));

            }
            return $this->redirectToRoute('assiduite_index');
        }

        return $this->render('enseignant/assiduite/new.html.twig', [
            'assiduite' => $assiduite,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/assiduite/delete/{id}/", name="assiduite_delete")
     */
    public function delete(Request $request, Assiduite $assiduite): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($assiduite);
        $entityManager->flush();


        return $this->redirectToRoute('assiduite_index');
    }
    /**
     * @Route("/assiduite/edit/{id}", name="assiduite_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Assiduite $assiduite): Response
    {
        $form = $this->createForm(AssiduiteType::class, $assiduite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('assiduite_index');
        }

        return $this->render('enseignant/assiduite/new.html.twig', [
            'assiduite' => $assiduite,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/assiduite/{id}", name="assiduite_show", methods={"GET"})
     */
    public function show(Assiduite $assiduite): Response
    {
        return $this->render('enseignant/assiduite/show.html.twig', [
            'assiduite' => $assiduite,
        ]);
    }


}
