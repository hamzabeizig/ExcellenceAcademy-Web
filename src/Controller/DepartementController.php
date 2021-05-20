<?php

namespace App\Controller;

use App\Entity\DepartementSearch;

use App\Entity\Reunion;
use App\Entity\PropertySearch;
use App\Entity\User;
use App\Form\DepartementSearchType;
use App\Form\PropertySearchType;
use App\Form\Reunion1Type;
use App\Entity\Departement;
use App\Form\DepartementType;
use App\Repository\ReunionRepository;

use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Serializer\SerializerInterface;



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
     * @Route("/departementm", name="departement_listm")
     *  @Method({"GET"})
     */
    public function indexm(Request $request ,SerializerInterface  $serializer): Response
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
            if ($nom != "") {
                //si on a fourni un nom d'article on affiche tous les articles ayant ce n

                $departements = $this->getDoctrine()->getRepository(Departement::class)->findBy(['nom' => $nom]);
                $data = $serializer->serialize($departements, 'json',['groups'=>'Departments']);
                $response = new Response($data);
            }
            else
                //si si aucun nom n'est fourni on affiche tous les articles
            {
                $departements = $this->getDoctrine()->getRepository(Departement::class)->findAll();

                $data = $serializer->serialize($departements, 'json',['groups'=>'Departments']);
                dump($departements);
                $response = new Response($data);
            }

            return $response;
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
     * @Route("/reunionm", name="reunion_listm")
     * @Method({"GET"})
     */

    public function indexReum (Request $request , SerializerInterface  $serializer)
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

                $data1=$serializer->serialize($reunions,'json',['groups'=>'Reunions']);
                $response =new Response($data1);
            } else if (($departement1 != null) && ($nom == null)) {
                $departement = $this->getDoctrine()->getRepository(Departement::class)->findBy(['nom' => $departement1]);
                $reunions = $this->getDoctrine()->getRepository(Reunion::class)->findBy(['departement' => $departement]);
                $data1=$serializer->serialize($reunions,'json',['groups'=>'Reunions']);
                $response =new Response($data1);
            } else if (($departement1 == null) && ($nom != null)) {
                $reunions = $this->getDoctrine()->getRepository(Reunion::class)->findBy(['nom' => $nom]);
                $data1=$serializer->serialize($reunions,'json',['groups'=>'Reunions']);
                $response =new Response($data1);
            } else
                $reunions = $this->getDoctrine()->getRepository(Reunion::class)->findAll();
            $data1=$serializer->serialize($reunions,'json',['groups'=>'Reunions']);
            $response =new Response($data1);


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
        $response->headers->set('Content_Type','application/json');
        return $response;

        //return $this->render('departement/reunion.html.twig', ['form' => $form->createView(), 'reunions' => $reunions,'data'=>$data]);
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
     * @Route("/departement/newm", name="new_departementm")
     * Method({"POST"})
     */
    public function newm (Request $request ,SerializerInterface $serializer)
    {
        $content = $request->getContent();
        $data = $serializer->deserialize($content,Departement::class,'json');
        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();

        return new Response('Department added ',Response::HTTP_CREATED);

        //return $this->render('departement/new.html.twig', ['form' =>
         //   $form->createView()]);


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
     * @Route("/departement/editm/{id}", name="edit_departementm")
     * Method({"GET", "POST"})
     */
    public function editm(Request $request, Departement $departement ,SerializerInterface $serializer)
    {
       /* $departement = new Departement;
        $departement = $this->getDoctrine()->getRepository(Departement::class)->find($id);

        $form = $this->createForm(DepartementType::class, $departement);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('departement_list');
        }*/
        $data=$serializer->serialize($departement,'json',['groups'=>'Departments']);

        $response =new Response($data);


        $content = $request->getContent();
        $data = $serializer->deserialize($content,Departement::class,'json');
        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        $response->headers->set('Content_Type','application/json');
        return $response;
       // return $this->render('departement/edit.html.twig', ['form' =>
            //$form->createView()]);


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
     * @Route("/departement/deletem/{id}",name="delete_departementm")
     * @Method({"DELETE"})
     *  */
    public function deletem(Request $request, $id)
    {
        $departement = $this->getDoctrine()->getRepository(Departement::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($departement);
        $entityManager->flush();

        return new Response('Department removed ',Response::HTTP_CREATED);
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
     * @Route("/reunion/newReum", name="new_reunionm")
     * Method({"POST"})
     */
    public function newReunionm(Request $request , SerializerInterface $serializer)
    {
        $content = $request->getContent();
        $data = $serializer->deserialize($content,Reunion::class,'json');
        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();

        return new Response('Reunion added ',Response::HTTP_CREATED);

        //return $this->render('departement/newReu.html.twig', ['form' => $form->createView()]);
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
     * @Route("/reunion/editm/{id}", name="edit_reunionm")
     * Method({"GET", "POST"})
     */
    public function editReum(Request $request, SerializerInterface $serializer,Reunion $reunion)
    {
      /*  $reunion = new Reunion();
        $reunion = $this->getDoctrine()->getRepository(Reunion::class)->find($id);

        $form = $this->createForm(Reunion1Type::class, $reunion);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('reunion_list');
        }*/
        $data=$serializer->serialize($reunion,'json', ['groups'=>'Reunions']);

        $response =new Response($data);

      //  return $this->render('departement/editReu.html.twig', ['form' =>
            //$form->createView()]);
       /* $content = $request->getContent();
        $data = $serializer->deserialize($content,Reunion::class,'json');
        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();*/
        $response->headers->set('Content_Type','application/json');
        return $response;

        //return new Response('Reunion added ',Response::HTTP_CREATED);

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
     * @Route("/reunion/deletem/{id}",name="delete_reunionm")
     * @Method({"DELETE"})
     *  */
    public function deleteReum(Request $request, $id)
    {
        $reunion = $this->getDoctrine()->getRepository(Reunion::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($reunion);
        $entityManager->flush();
        return new Response('Reunion removed ',Response::HTTP_CREATED);

       // $response = new Response();
        //$response->send();
       // return $this->redirectToRoute('reunion_list');
    }

    /**
     * @Route("/reunion/{id}" , name="list_ensreu")
     */
    public function showense($id): Response
    {
        $reunion = $this->getDoctrine()
            ->getRepository(Reunion::class)
            ->find($id);

        $users = $reunion->getUsers();
        return $this->render('departement/show.html.twig', ['enseignants' => $users, 'reunion' => $reunion]);


    }
    /**
     * @Route("/reunionm/{id}" , name="list_ensreum")
     * @Method ({"GET"})
     */
    public function showensem(Reunion $reunion , SerializerInterface $serializer)
    {


        $users = $reunion->getUsers();



        $data=$serializer->serialize($users,'json',['groups'=>'Reunions']);

        $response =new Response($data);
        $response->headers->set('Content_Type','application/json');
        return $response;
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
     * @Route("/departementm/{id}" , name="list_ensm")
     * @Method ({"GET"})
     */
    public function showEm(Departement $departement,SerializerInterface $serializer)
    {
        $data=$serializer->serialize($departement,'json',['groups'=>'Departments']);

        $response =new Response($data);
        $response->headers->set('Content_Type','application/json');
        return $response;
        //return $this->render('departement/liste.html.twig', ['departement' => $departement]);
    }
    /**
     * @Route("/EnsToAffect/{id}" , name="EnsToAffect")
     */
    public function EnsToAffect($id)
    {
        $reunion = $this->getDoctrine()
            ->getRepository(Reunion::class)
            ->find($id);

        $users = $reunion->getDepartement()->getUsers();
        $userss = [];
        foreach ($users as $user) {
            if (!($reunion->getUsers()->contains($user))) {
                $userss[] = $user;
            }
        }
        //echo( $enseignants);
        return $this->render('departement/affectEns.html.twig', ['enseignants' => $userss, 'idR' => $id]);
    }

    /**
     * @Route("/EnsToAffectm/{id}" , name="EnsToAffectm")
     */
    public function EnsToAffectm(Reunion $reunion, SerializerInterface $serializer)
    {
        ;

        $users = $reunion->getDepartement()->getUsers();
        $userss = [];
        foreach ($users as $user) {
            if (!($reunion->getUsers()->contains($user))) {
                $userss[] = $user;
            }
        }
        $data=$serializer->serialize($userss,'json',['groups'=>'Reunions']);
        $response =new Response($data);
        $response->headers->set('Content_Type','application/json');
        return $response;


        //return $this->render('departement/affectEns.html.twig', ['enseignants' => $userss, 'idR' => $id]);
    }

    /**
     * @Route("/affectEns/{id}/{idR}" , name="affectEns")
     */
    public function affectEns($id, $idR,\Swift_Mailer $mailer)
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        $reunion = $this->getDoctrine()
            ->getRepository(Reunion::class)
            ->find($idR);
        $users = $reunion->getDepartement()->getUsers();
        $dest=$user->getEmail();

        $reunion->addUser($user);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        $userss = [];
        foreach ($users as $user) {
            if (!($reunion->getUsers()->contains($user))) {
                $userss[] = $user;
                $message = (new \Swift_Message(' Reunion '))

                    ->setFrom('excellenceacademy878@gmail.com')
                    ->setTo($dest)

                    ->setBody('Salut :' .$user->getPrenom() .'Vous avez une reunion bientot . 
                    Veuillez vous visionner votre liste des reunions ou vous trouverez les details ');

                $mailer->send($message);
                $response = new Response();
                $response->send();


            }
        }

        return $this->render('departement/affectEns.html.twig', ['enseignants' => $userss, 'idR' => $id]);

    }
    /**
     * @Route("/affectEnsm/{id}/{idR}" , name="affectEnsm")
     * @Method ({"GET"})
     */
    public function affectEnsm(User $user,Reunion $reunion, $idR,\Swift_Mailer $mailer ,SerializerInterface $serializer)
    {

        $users = $reunion->getDepartement()->getUsers();
        $dest=$user->getEmail();

        $reunion->addUser($user);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        $userss = [];
        foreach ($users as $user) {
            if (!($reunion->getUsers()->contains($user))) {
                $userss[] = $user;
                $message = (new \Swift_Message(' Reunion '))

                    ->setFrom('excellenceacademy878@gmail.com')
                    ->setTo($dest)

                    ->setBody('Salut :' .$user->getPrenom() .'Vous avez une reunion bientot . 
                    Veuillez vous visionner votre liste des reunions ou vous trouverez les details ');

                $mailer->send($message);



            }
        }
        $data=$serializer->serialize($userss,'json',['groups'=>'Reunions']);
        $response =new Response($data);
        $response->headers->set('Content_Type','application/json');
        return $response;


       // return $this->render('departement/affectEns.html.twig', ['enseignants' => $userss, 'idR' => $id]);

    }
    /**
     * @Route("/suppens/{id}/{idR}" , name="suppens")
     */
    public function suppens($id, $idR) {
        $user =$this->getDoctrine()->getRepository(User::class)
            ->find($id);
        $reunion = $this->getDoctrine()->getRepository(Reunion::class)
            ->find($idR);
        $reunion->removeUser($user);
        $em=$this->getDoctrine()->getManager();
        $em->flush();
       return $this->render('departement/show.html.twig', ['reunion' => $reunion ,'enseignant' => $user, 'idR' => $id]);
    }
    /**
     * @Route("/suppensm/{id}/{idR}" , name="suppensm")
     */
    public function suppensm($id, $idR) {
        $user =$this->getDoctrine()->getRepository(User::class)
            ->find($id);
        $reunion = $this->getDoctrine()->getRepository(Reunion::class)
            ->find($idR);
        $reunion->removeUser($user);
        $em=$this->getDoctrine()->getManager();
        $em->flush();
        return new Response('Enseignant removed ',Response::HTTP_CREATED);

    }
    /**
     * @Route("/affiche/{id}" , name="affichereu")
     */
    public function affiche($id)
    {

        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $reunions=$user->getReunions();
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
     * @Route("/affichem/{id}" , name="affichereum")
     * @Method ({"GET"})
     */
    public function affichem(User $user, SerializerInterface $serializer)
    {

        $reunions=$user->getReunions();
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
        $data1=$serializer->serialize($reunions,'json', ['groups'=>'Reunion']);
        $response =new Response($data1);
        $response->headers->set('Content_Type','application/json');
        return $response;

        //return $this->render('departement/listeREu.html.twig', ['reunions' => $reunions,'data'=>$data]);
    }

}

