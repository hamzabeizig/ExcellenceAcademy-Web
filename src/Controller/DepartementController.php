<?php

namespace App\Controller;
use App\Entity\Reunion;
use App\Form\ReunionType;
use App\Entity\Departement;
use App\Form\DepartementType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\ArticleType;


class DepartementController extends AbstractController
{
    /**
     * @Route("/departement", name="departement_list")
     */
    public function index(): Response
    {
        $departements = $this->getDoctrine()->getRepository(Departement::class)->findAll();
        return $this->render('Departement/index.html.twig', ['departements' => $departements]);
    }
    /**
     * @Route("/reunion", name="reunion_list")
     */
    public function indexReu(): Response
    {
         $reunions= $this->getDoctrine()->getRepository(Reunion::class)->findAll();
        return $this->render('Departement/reunion.html.twig', ['reunions' => $reunions]);
    }

    /**
     * @Route("/departement/save")
     */
    public function save()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $departement = new Departement();
        $departement->setNom('Departement 3');
        $departement->setChefDep('khalil');

        $entityManager->persist($departement);
        $entityManager->flush();
        return new Response('Departement enregisté avec id ' . $departement->getId());
    }

    /**
     * @Route("/departement/new", name="new_departement")
     * Method({"GET", "POST"})
     */
    public function new(Request $request)
    {

        $departement = new Departement();
        $form = $this->createForm(DepartementType::class, $departement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $reunion = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($departement);
            $entityManager->flush();
            return $this->redirectToRoute('departement_list');
        }
        return $this->render('departement/new.html.twig', ['form' =>
            $form->createView()]);


    }

    /**
     * @Route("/departement/edit/{id}", name="edit_departement")
     * Method({"GET", "POST"})
     */
    public function edit(Request $request, $id) {
        $departement = new Departement;
        $departement = $this->getDoctrine()->getRepository(Departement::class)->find($id);

        $form = $this->createForm(DepartementType::class,$departement);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('departement_list');
        }

        return $this->render('departement/edit.html.twig', ['form' =>
            $form->createView()]);


}
 /**
  * @Route("/departement/delete/{id}",name="delete_departement")
  * @Method({"DELETE"})
  *  */
    public function delete(Request $request, $id) {
        $departement = $this->getDoctrine()->getRepository(Departement::class)->find($id);

 $entityManager = $this->getDoctrine()->getManager();
 $entityManager->remove($departement);
 $entityManager->flush();

 $response = new Response();
 $response->send();
 return $this->redirectToRoute('departement_list');
 }

/**
 * @Route("/reunion/newReu", name="new_reunion")
 * Method({"GET", "POST"})
 */
public function newReunion(Request $request) {
    $reunion = new Reunion();
    $form = $this->createForm(ReunionType::class,$reunion);
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid()) {
        $reunion = $form->getData();
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($reunion);
        $entityManager->flush();
        return $this->redirectToRoute('reunion_list');
    }
    return $this->render('departement/newReu.html.twig',['form' => $form->createView()]);
 }
    /**
     * @Route("/reunion/edit/{id}", name="edit_reunion")
     * Method({"GET", "POST"})
     */
    public function editReu(Request $request, $id) {
        $reunion = new Reunion();
        $reunion = $this->getDoctrine()->getRepository(Reunion::class)->find($id);

        $form = $this->createForm(ReunionType::class,$reunion);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('reunion_list');
        }

        return $this->render('departement/editReu.html.twig', ['form' =>
            $form->createView()]);


    }
    /**
     * @Route("/reunion/delete/{id}",name="delete_reunion")
     * @Method({"DELETE"})
     *  */
    public function deleteReu(Request $request, $id) {
        $reunion = $this->getDoctrine()->getRepository(Reunion::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($reunion);
        $entityManager->flush();

        $response = new Response();
        $response->send();
        return $this->redirectToRoute('reunion_list');
    }
    /**
     * @Route("/reunion/{id}" , name="reunion_show")
     */
    public function show($id){
        $reunion =$this->getDoctrine()->getRepository((Reunion::class))->find($id);
        return $this->render('departement/show.html.twig',['reunion'=>$reunion]);
    }

}
