<?php
namespace App\Controller;
use App\Entity\FindProperty;
use App\Entity\User;
use Monolog\Handler\Curl\Util;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Response;
Use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\LengthValidator;
use App\Form\FindFormType;
use \Symfony\Bundle\MonologBundle\SwiftMailer;


class UserController extends AbstractController
{
    /**
     * @Route("/User/list", name = "User_list")
     */
    public function home(Request $request)
    {

        $propertySearch = new FindProperty();

        $form = $this->createForm(FindFormType::class, $propertySearch);
        $form->handleRequest($request);

        $User = [];
        $User = $this->getDoctrine()->getRepository(User::class)->findAll();
        if ($form->isSubmitted() && $form->isValid()) {
            $nom = $propertySearch->getNom();
            $prenom = $propertySearch->getPrenom();

            if (($nom != "")) {
                $User = $this->getDoctrine()->getRepository(User::class)->findBy(['nom' => $nom]);
            } else
                $User = $this->getDoctrine()->getRepository(User::class)->findAll();
        }
        return $this->render('user/index.html.twig', ['form' => $form->createView(), 'User' => $User]);

    }


    /**
     * @Route("/User/new", name="new_User")
     * Method({"GET", "POST"})
     */
    public function new(Request $request, \Swift_Mailer $mailer)
    {
        $user = new User();
        $form = $this->createFormBuilder($user)
            ->add('nom', TextType::class, array('label' => 'Nom'))
            ->add('prenom', TextType::class, array('label' => 'Prenom'))
            ->add('user_Name', TextType::class, array('label' => 'Login'))
            ->add('email', EmailType::class, array('label' => 'E mail'))
            ->add('Role', ChoiceType::class, ['choices' => ['Enseignant' => 'Enseignant', 'Admin' => 'Admin','Etudiant' => 'Etudiant'],])
            ->add('date_de_naissance', BirthdayType::class, ['widget' => 'choice',], array('label' => 'Date de naissance'))
            ->add('Mdp', PasswordType::class, array('label' => 'Mot de passe'))
            ->add('save', SubmitType::class, array('label' => 'Créer'))->getForm();


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

//Mail___________________________________________________________________________________
            $message = (new \Swift_Message('ExcellenceAcademy : E_mail reçu'))
                ->setFrom('excellenceacademy878@gmail.com')
                ->setTo($user->getEmail())
                ->setBody('Salut : ' . $user->getPrenom() . ' Votre Compte d`excellence academy est Ajouteè avec Succeès , votre mot de passe sera : ' . $user->getMdp());

            $mailer->send($message);
//Mail___________________________________________________________________________________


            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('User_list');
        }
        return $this->render('user/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/user/edit/{id}", name="edit_User")
     * Method({"GET", "POST"})
     */
    public function edit(Request $request, $id)
    {

        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        $form = $this->createFormBuilder($user)
            ->add('nom', TextType::class, array('label' => 'Nom'))
            ->add('prenom', TextType::class, array('label' => 'Prenom'))
            ->add('user_Name', TextType::class, array('label' => 'Login'))
            ->add('email', EmailType::class, array('label' => 'E mail'))
            ->add('Role', ChoiceType::class, ['choices' => ['Enseignant' => 'Enseignant', 'Admin' => 'Admin','Etudiant' => 'Etudiant'],])
            ->add('date_de_naissance', BirthdayType::class, ['widget' => 'choice',], array('label' => 'Date de naissance'))
            ->add('Mdp', PasswordType::class, array('label' => 'Mot de passe'))
            ->add('save', SubmitType::class, array('label' => 'Modifier'))->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

        }
        return $this->render('user/edit.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/user/delete/{id}",name="delete_user")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, \Swift_Mailer $mailer, $id)
    {
        $u = $this->getDoctrine()->getRepository(User::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($u);
        $entityManager->flush();
        $dest = $u->getEmail();
//Mail___________________________________________________________________________________
        $message = (new \Swift_Message('E-mail reçu'))
            ->setFrom('excellenceacademy878@gmail.com')
            ->setTo($dest)
            ->setBody('Votre Compte est Supprimeè !');

        $mailer->send($message);
        //Mail___________________________________________________________________________________
        $response = new Response();
        $response->send();

        return $this->redirectToRoute('User_list');
    }

    public function read()
    {
        $User = $this->getDoctrine()->getRepository(User::class);
        return $util = $User->findAll();
    }

    /**
     * @Route("/user/bloque/{id}",name="bloque_user")
     */
    public function Bloque(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $u = $entityManager->getRepository(User::class)->find($id);

        $state = "Bloquè";
        $state1 = "Bloqué";
        $A = 'Admin';
        $E = 'Enseignant';

        if ($u->getRole() == $state) {
            $u->setRole('Enseignant');
        } elseif ($u->getRole() == $state1) {
            $u->setRole('Admin');
        } elseif ($u->getRole() == $A) {
            $u->setRole($state1);
        } else
            $u->setRole($state);
        $entityManager->flush();
        $response = new Response();
        $response->send();
        return $this->redirectToRoute('User_list');
    }


    public function mail(\Swift_Mailer $mailer, Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $u = $entityManager->getRepository(User::class)->find($id);
        $dest = $u->getEmail();

        $message = (new \Swift_Message('E-mail reçu'))
            ->setFrom('excellenceacademy878@gmail.com')
            ->setTo($dest)
            ->setBody('Votre Compte est Supprimeè !');

        $mailer->send($message);
        $response = new Response();
        $response->send();
        return $this->redirectToRoute('User_list');
    }


    /**
     * @Route("/user/editet/{id}", name="editet_User")
     * Method({"GET", "POST"})
     */
    public function editet(Request $request, $id)
    {

        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        $form = $this->createFormBuilder($user)
            ->add('nom', TextType::class, array('label' => 'Nom'))
            ->add('prenom', TextType::class, array('label' => 'Prenom'))
            ->add('user_Name', TextType::class, array('label' => 'Login'))
            ->add('email', EmailType::class, array('label' => 'E mail'))
            ->add('Role', ChoiceType::class, ['choices' => ['Enseignant' => 'Enseignant', 'Admin' => 'Admin','Etudiant' => 'Etudiant'],])
            ->add('date_de_naissance', BirthdayType::class, ['widget' => 'choice',], array('label' => 'Date de naissance'))
            ->add('Mdp', PasswordType::class, array('label' => 'Mot de passe'))
            ->add('save', SubmitType::class, array('label' => 'Modifier'))->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->render('FrontEtud.html.twig', ['form' => $form->createView()]);
        }
        return $this->render('FrontEtud.html.twig', ['form' => $form->createView()]);
    }


}
