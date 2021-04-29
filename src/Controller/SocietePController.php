<?php

namespace App\Controller;

use App\Entity\SocieteP;
use App\Form\SocietePType;
use App\Repository\SocietePRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Notifier\Message\SmsMessage;
use Symfony\Component\Notifier\TexterInterface;

class SocietePController extends AbstractController
{
    /**
     * @Route("/societe/p", name="societe_p")
     */
    public function index(): Response
    {
        return $this->render('societe_p/index.html.twig', [
            'controller_name' => 'SocietePController',
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @route("/AfficheSP",name="AfficheSP")
     */
    public function Affiche(){
        $repo=$this->getDoctrine()->getRepository(SocieteP::class) ;
        $societeP=$repo->findAll();
        return $this->render('societe_p/afficheSocieteP.html.twig',['societeP'=>$societeP]);

    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @route("societe_p/Add")
     */

    function Add(Request $request){
        $societep=new SocieteP() ;
        $form=$this->createForm(SocietePType::class,$societep);
        $form->add('Ajouter',SubmitType::class) ;
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($societep);
            $em->flush();
            $this->addFlash('success', 'Société ajoutée');

            return $this->redirectToRoute("AfficheSP");


        }

        return $this->render('societe_p/AddSP.html.twig',['form'=>$form->createView()]);


    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @route("/DeleteSP/{id}",name="dsp")
     */

    public function delete($id,SocietePRepository $repository){
        $societeP=$repository->find($id);
        $em = $this->getDoctrine()->getManager() ;
        $em -> remove($societeP);
        $em -> flush();
        $this->addFlash('success', 'Société supprimée');
        return $this->redirectToRoute("AfficheSP");

    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @route("societeP/updateSP/{id}" , name="updateSP")
     */

    public function update(SocietePRepository $repository,$id,Request $request){
        $societe_P=$repository->find($id);
        $form=$this->createForm(SocietePType::class,$societe_P);
        $form->add('update',SubmitType::class) ;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager() ;
            $em -> flush();
            $this->addFlash('success', 'Société modifiée');
            return $this->redirectToRoute("AfficheSP");

        }
        return $this->render('societe_p/updateSP.html.twig',['form'=>$form->createView()]);

    }
}
