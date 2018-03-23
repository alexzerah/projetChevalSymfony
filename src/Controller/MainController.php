<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Form\ForgotPassword;
use App\Form\PassChangeFormType;
use App\Form\PostType;
use App\Repository\FetchRepository;
use App\Services\Calculator;
use Swift_Mailer;
use Swift_Message;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\RouterInterface;

class MainController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('site/home.html.twig', [
        ]);
    }

    /**
     * @Route("/listeEvenements", name="listeEvent")
     */
    public function listeEvent()
    {
        return $this->render('site/listeEvent.html.twig', [
        ]);
    }

    /**
     * @Route("/event", name="event")
     */
    public function event()
    {
        return $this->render('site/event.html.twig', [
        ]);
    }

    /**
     * @Route("/connexion", name="connexion")
     */
    public function connexion()
    {
        return $this->render('site/connexion.html.twig', [
        ]);
    }

    /**
     * @Route("/mot-de-passe-oublie", name="forgotpassword")
     */
    public function forgotpassword(Request $request, Swift_Mailer $mailer, RouterInterface $router)
    {

        $form = $this->createForm(ForgotPassword::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $email = $form->get('email')->getData();
            $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $email]);

            if(!$user){
                return $this->render('site/forgotpassword.html.twig', [
                    'form' => $form->createView(),
                    'invalid_email' => $email,
                ]);
            }

            $token = uniqid('bde-', true);

            $url = $router->generate('changepassword', [
                'token' => $token,
            ]);
            $mailBody =  'Pour reset ton password click ici : ' . $url;

            $message = (new Swift_Message('Nouveau mot de passe'))
                ->setFrom(['chevalproject@gmail.com' => 'Projet Cheval'])
                ->setTo('charlotte.palma@teching.com')
                ->setBody($mailBody);
            $mailer->send($message);



        }



        return $this->render('site/forgotpassword.html.twig', [
            'form' => $form->createView(),
        ]);

    }


    /**
     * @Route("/changer-mon-mot-de-passe/{token}", name="changepassword")
     */
    public function changepassword(Request $request)
    {
        // Check is a user is logged in
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // Set the user
        $user = $this->getUser();

        // user form update
        $form = $this->createForm(PassChangeFormType::class);

        return $this->render('site/changepassword.html.twig', [
            'form' => $form->createView(),
        ]);
    }








    /**
     * @Route("/404", name="quatrecentquatre")
     */
    public function quatrecentquatre()
    {
        return $this->render('site/error404.html.twig', [
        ]);
    }


}
