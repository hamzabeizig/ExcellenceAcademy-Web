<?php

namespace App\Controller;

use App\Entity\DemConvention;
use App\Entity\Evenement;
use App\Entity\Participation;
use App\Entity\PropertySearchw;
use App\Form\EvenementFormType;
use App\Form\PropertySearchTypew;
use App\Repository\DemConventionRepository;
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
    public function Affiche(Request $request){
        $propertySearch = new PropertySearchw();
        $form = $this->createForm(PropertySearchTypew::class,$propertySearch);
        $form->handleRequest($request);
        //initialement le tableau des articles est vide,
        //c.a.d on affiche les articles que lorsque l'utilisateur clique sur le bouton rechercher
        $articles= [];

        if($form->isSubmitted() && $form->isValid()) {
            //on récupère le nom d'article tapé dans le formulaire
            $nom = $propertySearch->getNom();
            $articles = $this->getDoctrine()->getRepository(Evenement::class)->findBy(['nom_evenement' => $nom]);
        } else

                $articles= $this->getDoctrine()->getRepository(Evenement::class)->findAll();



        return  $this->render('evenement/affiche.html.twig',[ 'form' =>$form->createView(), 'evenement' => $articles]);

    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @route("evenement/Add/{id_et}", name="org")
     */

    function Add(Request $request,$id_et){
        $evenement=new Evenement() ;
        $form=$this->createForm(EvenementFormType::class,$evenement);
        $form->add('Ajouter',SubmitType::class) ;
        $evenement->setEtat("en attente");
        $evenement->setIdUser($id_et);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($evenement);
            $em->flush();
            return $this->redirectToRoute("Affiche");
            $this->addFlash('success', 'votre demande est en cours de traitement');



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
        $this->addFlash('success', 'evenement supprimé');

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
            $this->addFlash('success', 'evenement modifié');

        }
        return $this->render('evenement/update.html.twig',['form'=>$form->createView()]);

    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @route("evenement/Participer/{id_event}/{nbrplace}/{nom_event}" , name="participer")
     */

    function Participer(Request $request, EvenementRepository $repository, $id_event,$nbrplace,$nom_event){
        $participation=new Participation() ;
        $participation->setIdEvent($id_event) ;
        $participation->setIdUser(2) ;
        $participation->setNomEvenement($nom_event);
        $evenement=$repository->find($id_event);
        $evenement->setNbrPlace($nbrplace) ;
        $em=$this->getDoctrine()->getManager();
        $em->persist($participation);
        $em->persist($evenement);
        $em->flush();
        $this->addFlash('success', 'vous avez participé dans cet evenement');
            return $this->redirectToRoute("Affiche");


        }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @route("/evenement/participation",name="participation")
     */
    public function AfficheP(){
        $repo=$this->getDoctrine()->getRepository(Participation::class) ;
        $participation=$repo->findAll();
        return $this->render('evenement/affichep.html.twig',['participation'=>$participation]);

    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @route("/accepterevent/{id_event}",name="accept")
     */

    public function Accepter(EvenementRepository $repository,$id_event,Request $request,\Swift_Mailer $mailer){
        $event=$repository->find($id_event);
        $event->setEtat("acceptée");
        $em = $this->getDoctrine()->getManager() ;
        $em -> persist($event);
        $em -> flush();

        $message = (new \Swift_Message('Demande Evenement'))
            ->setFrom('excellenceacademy878@gmail.com')
            ->setTo('hamza.beizig@esprit.tn')
            ->setBody('Votre demande de l evenement a été bien acceptée.')

        ;

        $mailer->send($message);
        $this->addFlash('success', 'demande acceptée');
        return $this->redirectToRoute("afficheeva");


    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @route("/accepterevent/{id_event}",name="refuse")
     */

    public function Refuser(EvenementRepository $repository,$id_event,Request $request,\Swift_Mailer $mailer){
        $event=$repository->find($id_event);
        $event->setEtat("refusée");
        $em = $this->getDoctrine()->getManager() ;
        $em -> persist($event);
        $em -> flush();

        $message = (new \Swift_Message('Demande Evenement'))
            ->setFrom('excellenceacademy878@gmail.com')
            ->setTo('hamza.beizig@esprit.tn')
            ->setBody('Votre demande de l evenement a été refusée.')

        ;

        $mailer->send($message);
        $this->addFlash('success', 'demande refusée');
        return $this->redirectToRoute("afficheeva");


    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @route("/evenementadmin",name="afficheeva")
     */
    public function AfficheEventA(){
        $repo=$this->getDoctrine()->getRepository(Evenement::class) ;
        $evenement=$repo->findBy(['etat' => 'en attente']);
        return $this->render('evenement/affichea.html.twig',['evenement'=>$evenement]);

    }
}
