<?php

namespace App\Controller;

use App\Entity\DepartementSearch;
use App\Entity\Enseignant;
use App\Entity\EnseignantAdd;
use App\Entity\Reunion;
use App\Entity\PropertySearch;
use App\Form\DepartementSearchType;
use App\Form\PropertySearchType;
use App\Form\EnseignantAddType;
use App\Form\Reunion1Type;
use App\Entity\Departement;
use App\Form\DepartementType;
use App\Repository\ReunionRepository;
use phpDocumentor\Reflection\Types\Boolean;
use phpDocumentor\Reflection\Types\Integer;
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
    public function index(Request $request): Response
    {

        $DepartementSearch = new DepartementSearch();
        $form = $this->createForm(DepartementSearchType::class, $DepartementSearch);
        $form->handleRequest($request);
        //initialement le tableau des articles est vide,
        //c.a.d on affiche les articles que lorsque l'utilisateur
        //clique sur le bouton rechercher
        $departements = [];

        if ($form->isSubmitted() && $form->isValid()) {
            //on récupère le nom d'article tapé dans le formulair
            $nom = $DepartementSearch->getNom();
            if ($nom != "")
                //si on a fourni un nom d'article on affiche tous les articles ayant ce n

                $departements = $this->getDoctrine()->getRepository(Departement::class)->findBy(['nom' => $nom]);
            else
                //si si aucun nom n'est fourni on affiche tous les articles
                $departements = $this->getDoctrine()->getRepository(Departement::class)->findAll();
        }
        return $this->render('departement/index.html.twig', ['form' => $form->createView(), 'departements' => $departements]);
    }


    /**
     * @Route("/reunion", name="reunion_list")
     */

    public function indexReu(Request $request)
    {
        $propertySearch = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class, $propertySearch);
        $form->handleRequest($request);
        //initialement le tableau des articles est vide,
        //c.a.d on affiche les articles que lorsque l'utilisateur
        //clique sur le bouton rechercher
        $reunions = [];


        if ($form->isSubmitted() && $form->isValid()) {
            //on récupère le nom d'article tapé dans le formulaire
            //$departement = $propertySearch->getDepartement()->getNom();
            $departement1 = $propertySearch->getDepartement();
            $nom = $propertySearch->getNom();
            if (($departement1 != null) && ($nom != null)) {
                $departement = $this->getDoctrine()->getRepository(Departement::class)->findBy(['nom' => $departement1]);
                $reunions = $this->getDoctrine()->getRepository(Reunion::class)->findBy(['departement' => $departement, 'nom' => $nom]);
            } else if (($departement1 != null) && ($nom == null)) {
                $departement = $this->getDoctrine()->getRepository(Departement::class)->findBy(['nom' => $departement1]);
                $reunions = $this->getDoctrine()->getRepository(Reunion::class)->findBy(['departement' => $departement]);
            } else if (($departement1 == null) && ($nom != null)) {
                $reunions = $this->getDoctrine()->getRepository(Reunion::class)->findBy(['nom' => $nom]);
            } else
                $reunions = $this->getDoctrine()->getRepository(Reunion::class)->findAll();


        }
        $rdvs=[];
        foreach ($reunions as $event)
        {
            $rdvs[]=[
                'id' => $event->getId(),
                'start' => $event->getStart()->format('Y-m-d H:i:s'),
                'end' => $event->getEnd()->format('Y-m-d H:i:s'),
                'title' => $event->getNom()
            ];
        }
        $data= json_encode($rdvs);
         return $this->render('departement/reunion.html.twig', ['form' => $form->createView(), 'reunions' => $reunions,'data'=>$data]);
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
    public function edit(Request $request, $id)
    {
        $departement = new Departement;
        $departement = $this->getDoctrine()->getRepository(Departement::class)->find($id);

        $form = $this->createForm(DepartementType::class, $departement);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

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
    public function delete(Request $request, $id)
    {
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
    public function newReunion(Request $request)
    {
        $reunion = new Reunion();
        $form = $this->createForm(Reunion1Type::class, $reunion);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $reunion = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reunion);
            $entityManager->flush();
            return $this->redirectToRoute('reunion_list');
        }
        return $this->render('departement/newReu.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/reunion/edit/{id}", name="edit_reunion")
     * Method({"GET", "POST"})
     */
    public function editReu(Request $request, $id)
    {
        $reunion = new Reunion();
        $reunion = $this->getDoctrine()->getRepository(Reunion::class)->find($id);

        $form = $this->createForm(Reunion1Type::class, $reunion);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

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
    public function deleteReu(Request $request, $id)
    {
        $reunion = $this->getDoctrine()->getRepository(Reunion::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($reunion);
        $entityManager->flush();

        $response = new Response();
        $response->send();
        return $this->redirectToRoute('reunion_list');
    }

    /**
     * @Route("/reunion/{id}" , name="list_ensreu")
     */
    public function showense($id): Response
    {
        $reunion = $this->getDoctrine()
            ->getRepository(Reunion::class)
            ->find($id);

        $enseignants = $reunion->getEnseignants();
        return $this->render('departement/show.html.twig', ['enseignants' => $enseignants, 'reunion' => $reunion]);


    }

    /**
     * @Route("/departement/{id}" , name="list_ens")
     */
    public function showE($id)
    {
        $departement = $this->getDoctrine()->getRepository((Departement::class))->find($id);
        //  $ens=$this->getDoctrine()->getRepository((Enseignant::class))->findBy($departement);

        //  return $this->render('departement/liste.html.twig',['ens'=>$ens]);
        return $this->render('departement/liste.html.twig', ['departement' => $departement]);
    }

    /**
     * @Route("/EnsToAffect/{id}" , name="EnsToAffect")
     */
    public function EnsToAffect($id)
    {
        $reunion = $this->getDoctrine()
            ->getRepository(Reunion::class)
            ->find($id);

        $enseignants = $reunion->getDepartement()->getenseignants();
        $enseignantss = [];
        foreach ($enseignants as $enseignant) {
            if (!($reunion->getEnseignants()->contains($enseignant))) {
                $enseignantss[] = $enseignant;
            }
        }
        //echo( $enseignants);
        return $this->render('departement/affectEns.html.twig', ['enseignants' => $enseignantss, 'idR' => $id]);
    }

    /**
     * @Route("/affectEns/{id}/{idR}" , name="affectEns")
     */
    public function affectEns($id, $idR,\Swift_Mailer $mailer)
    {
        $enseignant = $this->getDoctrine()
            ->getRepository(Enseignant::class)
            ->find($id);

        $reunion = $this->getDoctrine()
            ->getRepository(Reunion::class)
            ->find($idR);
        $enseignants = $reunion->getDepartement()->getenseignants();
        $dest=$enseignant->getEmail();

        $reunion->addEnseignant($enseignant);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        $enseignantss = [];
        foreach ($enseignants as $enseignant) {
            if (!($reunion->getEnseignants()->contains($enseignant))) {
                $enseignantss[] = $enseignant;
                $message = (new \Swift_Message(' Reunion '))

                    ->setFrom('excellenceacademy878@gmail.com')
                    ->setTo('dhia.mathlouthi@esprit.tn')

                    ->setBody('Salut :' .$enseignant->getPrenom() .'Vous avez une reunion bientot . 
                    Veuillez vous visionner votre liste des reunions ou vous trouverez les details ');

                $mailer->send($message);
                $response = new Response();
                $response->send();


            }
        }

        return $this->render('departement/affectEns.html.twig', ['enseignants' => $enseignantss, 'idR' => $id]);

    }
    /**
     * @Route("/suppens/{id}/{idR}" , name="suppens")
     */
    public function suppens($id, $idR) {
        $enseignant =$this->getDoctrine()->getRepository(Enseignant::class)
            ->find($id);
        $reunion = $this->getDoctrine()->getRepository(Reunion::class)
            ->find($idR);
        $reunion->removeEnseignant($enseignant);
        $em=$this->getDoctrine()->getManager();
        $em->flush();
        return $this->render('departement/show.html.twig', ['reunion' => $reunion ,'enseignant' => $enseignant, 'idR' => $id]);
    }
    /**
     * @Route("/affiche/{id}" , name="affichereu")
     */
    public function affiche($id)
    {

        $enseignant = $this->getDoctrine()->getRepository(Enseignant::class)
            ->find($id);
        $reunions=$enseignant->getReunions();
        $rdvs=[];
        foreach ($reunions as $event)
        {
            $rdvs[]=[
                'id' => $event->getId(),
                'start' => $event->getStart()->format('Y-m-d H:i:s'),
                'end' => $event->getEnd()->format('Y-m-d H:i:s'),
                'title' => $event->getNom()
            ];
        }
        $data= json_encode($rdvs);
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        return $this->render('departement/listeREu.html.twig', ['reunions' => $reunions,'data'=>$data]);
    }
    /**
     * @Route("/aa" , name="aa")
     */
    public function aa( ReunionRepository $reunion)
    {
        $events =$reunion->findAll();
        $rdvs=[];
        foreach ($events as $event)
        {
            $rdvs[]=[
                'id' => $event->getId(),
                'start' => $event->getStart()->format('Y-m-d H:i:s'),
                'end' => $event->getEnd()->format('Y-m-d H:i:s'),
                'title' => $event->getNom()
            ];
        }
        $data= json_encode($rdvs);

        return $this->render('frontOffice.html.twig' , compact('data'));
    }
}

