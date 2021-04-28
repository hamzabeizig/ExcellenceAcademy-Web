<?php


namespace App\Controller;
use App\Entity\AuthClass;
use App\Entity\Enseignant;
use App\Entity\User;
use App\Form\AuthC;
use Monolog\Handler\Curl\Util;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Response;
Use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Session\Session;


class Auth extends AbstractController
{
    /**
     * @Route("/", name = "User_auth")
     ** Method({"GET", "POST"})
     */
    public function auth(Request $request)
    {

        $session = $request->getSession();
        $AuthClass = new AuthClass();
        $form = $this->createForm(AuthC::class, $AuthClass);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $mail = $AuthClass->getEmail();
            $md = $AuthClass->getMdp();
            $repo = $this->getDoctrine()->getRepository(User::class)->findBy(array('email' => $mail , 'Mdp' => $md));

            if (count($repo) > 0) {

                $role = $repo[0];
                $maV = $session->get('maV');
                $idu = $role->getId();
                $session->set('maV',$idu);

                if ($role->getRole() == 'Admin')
                    return $this->redirectToRoute('departement_list');
                else if ($role->getRole() == 'Enseignant')
                    return $this->redirect('user/edit/'.$idu);
                else if ($role->getRole() == 'Etudiant')
                    return $this->redirect('user/editet/'.$idu);
                else
                    echo '<script>alert("Votre compte est desactiveè pour le moment!")</script>';
            }
            else if(count($repo) == 0)
                echo '<script>alert("Un erreur c\'est produits ! Verifier Vos Paramètres !")</script>';
        }
        $session->clear();
        return $this->render('user/auth.html.twig', ['form' => $form->createView()]);
    }


}