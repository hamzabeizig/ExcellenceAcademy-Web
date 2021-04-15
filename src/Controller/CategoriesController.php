<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategoriesType;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesController extends AbstractController
{
    /**
     * @Route("/categories", name="categories")
     */
    public function index(): Response
    {
        return $this->render('categories/index.html.twig', [
            'controller_name' => 'CategoriesController',
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @route("/AfficheC",name="AfficheC")
     */
    public function Affiche(){
        $repo=$this->getDoctrine()->getRepository(Categorie::class) ;
        $categorie=$repo->findAll();
        return $this->render('categorie/afficheCategorie.html.twig',['categorie'=>$categorie]);

    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @route("categorie/Add")
     */

    function Add(Request $request){
        $categorie=new Categorie() ;
        $form=$this->createForm(CategoriesType::class,$categorie);
        $form->add('Ajouter',SubmitType::class) ;
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();
            return $this->redirectToRoute("AfficheC");


        }

        return $this->render('categorie/AddCategorie.html.twig',['form'=>$form->createView()]);


    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @route("/DeleteC/{id}",name="dc")
     */

    public function delete($id,CategorieRepository $repository){
        $categorie=$repository->find($id);
        $em = $this->getDoctrine()->getManager() ;
        $em -> remove($categorie);
        $em -> flush();
        return $this->redirectToRoute("AfficheC");

    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @route("categorie/update/{id}" , name="updateC")
     */

    public function update(CategorieRepository $repository,$id,Request $request){
        $categorie=$repository->find($id);
        $form=$this->createForm(CategoriesType::class,$categorie);
        $form->add('update',SubmitType::class) ;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager() ;
            $em -> flush();
            return $this->redirectToRoute("AfficheC");

        }
        return $this->render('categorie/updatecategorie.html.twig',['form'=>$form->createView()]);

    }
}
