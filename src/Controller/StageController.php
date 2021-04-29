<?php

namespace App\Controller;

use App\Entity\DemConvention;
use App\Entity\Stage;
use App\Form\PostulationType;
use App\Form\StageType;
use App\Repository\DemConventionRepository;
use App\Repository\StageRepository;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use \Symfony\Bundle\MonologBundle\SwiftMailer;




class StageController extends AbstractController
{
    public  $nb=1 ;

    /**
     * @Route("/stageC", name="stage")
     */
    public function index(): Response
    {
        return $this->render('stage/index.html.twig', [
            'controller_name' => 'StageController',
        ]);
    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @route("/stagea",name="AfficheStage")
     */
    public function Affiche(){
        $repo=$this->getDoctrine()->getRepository(Stage::class) ;
        $stage=$repo->findAll();

        return $this->render('stage/affichestage.html.twig',['stage'=>$stage]);

    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @route("/DeleteStage/{id}",name="ds")
     */

    public function delete($id,StageRepository $repository){
        $stage=$repository->find($id);
        $em = $this->getDoctrine()->getManager() ;
        $em -> remove($stage);
        $em -> flush();
        $this->addFlash('success', 'Stage supprimé');
        return $this->redirectToRoute("AfficheStage");

    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @route("stage/Add" )
     */

    function Add(Request $request){
        $stage=new Stage();
        $form=$this->createForm(StageType::class,$stage);
        $form->add('Ajouter', SubmitType::class) ;
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($stage);
            $em->flush();
            $this->addFlash('success', 'Stage ajouté');
            return $this->redirectToRoute("AfficheStage");


        }

        return $this->render('stage/AddStage.html.twig',['form'=>$form->createView()]);


    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @route("/updateStage/{id}" , name="updateStage")
     */

    public function update(StageRepository $repository,$id,Request $request){
        $stage=$repository->find($id);
        $form=$this->createForm(StageType::class,$stage);
        $form->add('update',SubmitType::class) ;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager() ;
            $em -> flush();
            $this->addFlash('success', 'Stage modifié');
            return $this->redirectToRoute("AfficheStage");

        }
        return $this->render('stage/updateStage.html.twig',['form'=>$form->createView()]);

    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @route("/etudiant/stage",name="affichestageetudiant")
     */
    public function AfficheStageE(){
        $repo=$this->getDoctrine()->getRepository(Stage::class) ;
        $stage=$repo->findAll();
        return $this->render('stage/affichestageetudiant.html.twig',['stage'=>$stage]);

    }



    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @route("stage/convention/{id}/{id_et}" , name="demanderC")
     */

    function DemanderC (Request $request, $id,$id_et,UserRepository $repository)
    {
        $user=$repository->find($id_et);
        $DemandeC = new DemConvention();
        $DemandeC->setIdUser($id_et);
        $DemandeC->setIdStage($id);
        $DemandeC->setUserName($user
        ->getUserName());
        $DemandeC->setEtat("en attente");
        $DemandeC->setDate(new \DateTime('now'));
        $DemandeC->setEmail($user->getEmail());
        $em = $this->getDoctrine()->getManager();
        $em->persist($DemandeC);
        $em->flush();

        $this->addFlash('success', 'Votre demande est en cours de traitement');
        return $this->redirectToRoute("affichestageetudiant");

    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @route("/convention",name="affichec")
     */
    public function AfficheConv(){
        $repo=$this->getDoctrine()->getRepository(DemConvention::class) ;
        $conv=$repo->findBy(['etat' => 'en attente']);
        return $this->render('stage/affichec.html.twig',['conv'=>$conv]);

    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @route("/refuserconv/{id_conv}",name="ref")
     */

    public function Refuser(DemConventionRepository $repository,$id_conv ,Request $request ,\Swift_Mailer $mailer){


        $conv=$repository->find($id_conv);
        $conv->setEtat("refusée");
        $em = $this->getDoctrine()->getManager() ;
        $em -> persist($conv);
        $em -> flush();

        $message = (new \Swift_Message('Demande de convention'))
            ->setFrom('excellenceacademy878@gmail.com')
            ->setTo($conv->getEmail())
            ->setBody('Salut : ' .$conv->getUserName() .' Votre demande de convention pour le stage  d`id:  '. $conv->getIdStage().' a été refusée')
        ;

        $mailer->send($message);
        $this->addFlash('success', 'Demande refusée');
        return $this->redirectToRoute("affichec");
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @route("/accepterconv/{id_conv}",name="acc")
     */

    public function Accepter(DemConventionRepository $repository,$id_conv,Request $request,\Swift_Mailer $mailer){
        $conv=$repository->find($id_conv);
        $conv->setEtat("acceptée");
        $em = $this->getDoctrine()->getManager() ;
        $em -> persist($conv);
        $em -> flush();

        $message = (new \Swift_Message('Demande de Convention'))
            ->setFrom('excellenceacademy878@gmail.com')
            ->setTo($conv->getEmail())
            ->setBody('Votre demande de convention a été bien acceptée, vous trouvez ci joint une copie de la convention')
            ->attach(\Swift_Attachment::fromPath('C:\xampp\htdocs\code-Army2\public\fichiers\convention.pdf'))
        ;
      var_dump($conv->getEmail());
        $mailer->send($message);
        $this->addFlash('success', 'demande acceptée');
        return $this->redirectToRoute("affichec");


    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @route("stage/postuler/{id_stage}" , name="pos")
     */

    function Postuler(Request $request,StageRepository $repository, $id_stage,\Swift_Mailer $mailer){
        $stage=$repository->find($id_stage);
        $form=$this->createForm(PostulationType::class);
        $form->add('Ajouter', SubmitType::class) ;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $message = (new \Swift_Message('Postulation'))
                ->setFrom('excellenceacademy878@gmail.com')
                ->setTo('mohamedkhalil.guedria@esprit.tn')
                ->setBody('nouvelle postulation')
                ->attach(\Swift_Attachment::fromPath('C:\xampp\htdocs\code-Army2\public\fichiers\CV_Mohamed-Khalil Guedria.pdf'))
                ->attach(\Swift_Attachment::fromPath('C:\xampp\htdocs\code-Army2\public\fichiers\Lettre De Motivation_Mohamed-Khalil Guedria.pdf'))



            ;
            $mailer->send($message);
            $this->addFlash('success', 'votre demande a été bien envoyée');
    }
        return $this->render('stage/postuler.html.twig',['form'=>$form->createView() ,'stage'=>$stage]);


    }
}
