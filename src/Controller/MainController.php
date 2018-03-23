<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\ContactFormType;
use App\Form\PassChangeFormType;
use App\Form\PostType;
use App\Repository\FetchRepository;
use App\Services\Calculator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction(Request $request, \Swift_Mailer $mailer)
    {
        $form = $this->createForm(ContactFormType::class);

        // handles data from POST requests
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $data = (object) $form->getData();

                $message = (new \Swift_Message($data->subject))
                    ->setFrom($data->email)
                    ->setTo('chevalproject@gmail.com')
                    ->setBody($data->message);

                $mailer->send($message);

            } else {
                return array(
                    'data' => 'prout'
                );
            }
        }

        return $this->render('site/contact.html.twig', [
            'contactForm' => $form->createView()
        ]);
    }

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
    public function forgotpassword()
    {
        return $this->render('site/forgotpassword.html.twig', [
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

    /**
     * @Route("/changer-mon-mot-de-passe", name="changepassword")
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

}
