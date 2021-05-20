<?php


namespace App\Controller;


use App\Entity\Assiduite;
use App\Entity\Matiere;
use App\Form\AssiduiteType;
use App\Form\MatiereType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MatiereController
 * @package App\Controller
 * @Route("/matiere",name="matiere_")
 */
class MatiereController extends Controller
{

    /**
     * @Route("/list",name="list_matiere")
     * @param Request $request
     * @return Response
     */
    public function listMatiere(Request $request):Response
    {
        $matiere=$this->getDoctrine()->getRepository(Matiere::class)->findAll();

        return $this->render('enseignant/matiere/list.html.twig', [
            'matiere' => $matiere,
        ]);
    }
    /**
     * @Route("/addmatiere",name="add_matiere", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function addMatiere(Request $request):Response
    {
        $matiere = new Matiere();
        $form = $this->createForm(MatiereType::class,$matiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($matiere);
            $entityManager->flush();

            return $this->redirectToRoute('matiere_list_matiere');
        }

        return $this->render('enseignant/matiere/addMatiere.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}",name="show_matiere")
     * @param Matiere $matiere
     * @return Response
     */
    public function show(Matiere $matiere):Response
    {
        return  $this->render('enseignant/matiere/show.html.twig', [
            'matiere' => $matiere,

        ]);
    }

    /**
     * @Route("/edit/{id}", name="matiere_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Matiere $matiere): Response
    {

        $form = $this->createForm(MatiereType::class, $matiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $request->getMethod()=='POST') {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('matiere_list_matiere');
        }

        return $this->render('enseignant/matiere/addMatiere.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}/", name="matiere_delete")
     */
    public function delete(Request $request, Matiere $matiere): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($matiere);
        $entityManager->flush();


        return $this->redirectToRoute('matiere_list_matiere');
    }

}