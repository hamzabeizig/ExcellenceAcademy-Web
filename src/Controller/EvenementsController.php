<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementFormType;
use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EvenementsController extends AbstractController
{
    /**
     * @Route("/evenement", name="evenement")
     */
    public function index(): Response
    {
        return $this->render('evenement/index.html.twig', [
            'controller_name' => 'EvenementController',
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @route("/Affiche",name="Affiche")
     */
    public function Affiche(){
        $repo=$this->getDoctrine()->getRepository(Evenement::class) ;
       //$evenement=$repo->findBy(['etat' => 'aprouvée']);//
        $evenement=$repo->findAll();
        return $this->render('evenement/affiche.html.twig',['evenement'=>$evenement]);

    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @route("evenement/Add")
     */

    function Add(Request $request){
        $evenement=new Evenement() ;
        $form=$this->createForm(EvenementFormType::class,$evenement);
        $form->add('Ajouter',SubmitType::class) ;
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($evenement);
            $em->flush();
            return $this->redirectToRoute("Affiche");


        }

        return $this->render('evenement/Add.html.twig',['form'=>$form->createView()]);


    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @route("/Delete/{id_evenement}",name="d")
     */

    public function delete($id_evenement,EvenementRepository $repository){
        $evenement=$repository->find($id_evenement);
        $em = $this->getDoctrine()->getManager() ;
        $em -> remove($evenement);
        $em -> flush();
        return $this->redirectToRoute("Affiche");

    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @route("evenement/update/{id_evenement}" , name="update")
     */

    public function update(EvenementRepository $repository,$id_evenement,Request $request){
        $evenement=$repository->find($id_evenement);
        $form=$this->createForm(EvenementFormType::class,$evenement);
        $form->add('update',SubmitType::class) ;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager() ;
            $em -> flush();
            return $this->redirectToRoute("Affiche");

        }
        return $this->render('evenement/update.html.twig',['form'=>$form->createView()]);

    }
}
