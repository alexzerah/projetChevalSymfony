<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Form\ForgotPassword;
use App\Form\PasswordResetType;
use App\Form\ContactFormType;
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
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

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
    public function forgotpassword(Request $request, Swift_Mailer $mailer)
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

            $url = $this->generateUrl('changepassword', [
                'token' => $token,
            ], UrlGeneratorInterface::ABSOLUTE_URL);
            $mailBody =  'Pour reset ton password click ici : ' . $url;

            $message = (new Swift_Message('Nouveau mot de passe'))
                ->setFrom(['chevalproject@gmail.com' => 'Projet Cheval'])
                ->setTo('charlotte.palma@teching.com')
                ->setBody($mailBody);
            $mailer->send($message);

            $user->setResetPasswordToken($token);
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Hey coco, va checker tes mails ;)');

            return $this->redirectToRoute('login');
        }

        return $this->render('site/forgotpassword.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/changer-mon-mot-de-passe/{token}", name="changepassword")
     */
    public function changepassword(Request $request, string $token, EncoderFactoryInterface $factory)
    {
        /** @var User $user */
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['resetPasswordToken' => $token]);
        if(!$user){
            $this->addFlash('error', 'raté');
            return $this->redirectToRoute('login');
        }

        // user form update
        $form = $this->createForm(PasswordResetType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $encoder = $factory->getEncoder(User::class);
            $user->setPassword($encoder->encodePassword($user->getPlainPassword(), $user->getSalt()));
            $user->eraseCredentials();
            $user->setResetPasswordToken(null);

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Mot de passe mis à jour avec succès');

            return $this->redirectToRoute('login');
        }

        return $this->render('site/changepassword.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
