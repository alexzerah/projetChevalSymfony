<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ForgotPassword;
use App\Form\PasswordResetType;
use App\Form\ContactFormType;
use Swift_Message;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class MainController extends Controller
{
    // Setup
    private $mailer;
    private $factory;

    protected function getErrorsAsArray(FormInterface $form)
    {
        $errors = array();
        foreach ($form->getErrors() as $error)
            $errors[] = $error->getMessage();

        foreach ($form->all() as $key => $child) {
            if ($err = $this->getErrorsAsArray($child))
                $errors[$key] = $err;
        }
        return $errors;
    }

    // Constructor
    public function __construct(\Swift_Mailer $mailer, EncoderFactoryInterface $factory)
    {
        $this->mailer = $mailer;
        $this->factory = $factory;
    }

    /**
     * This route shows a contact form.
     * @Route("/contact", name="contact")
     */
    public function contactAction(Request $request)
    {
        // Create the form
        $form = $this->createForm(ContactFormType::class);

        // Listen post requests
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            if ($form->isValid()) {

                // Cast to an object
                $content = (object) $form->getData();

                // [!] Cannot setFrom a different mail than ours, need Email Entity and save data
                // then send confirmation mail to user
                // For test purpose : we just send a notification mail
                $message = (new \Swift_Message($content->subject))
                    ->setFrom(['chevalproject@gmail.com' => '[BDE] Horse'])
                    ->setTo([$content->email => $content->name])
                    ->setBody(
                        'Hey '.$content->name.', ton super BDE a bien reçu ta requête, il te répondra dans les 48 heures !'
                    );

                $this->mailer->send($message);

                $this->addFlash('success', 'Merci de nous avoir contacté !');

            } else {
                $this->addFlash('error', 'Zut...');
            }
        }

        // Render
        return $this->render('site/contact.html.twig', [
            'contactForm' => $form->createView()
        ]);
    }

    /**
     * This route shows login page.
     * @Route("/connexion", name="connexion")
     */
    public function connexion()
    {
        return $this->render('site/connexion.html.twig', [
        ]);
    }

    /**
     * This route shows forgot password page.
     * @Route("/mot-de-passe-oublie", name="forgotpassword")
     */
    public function forgotPassAction(Request $request)
    {
        $form = $this->createForm(ForgotPassword::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();
            $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $email]);

            if (!$user) {
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
                ->setTo($user->getEmail())
                ->setBody($mailBody);

            $this->mailer->send($message);

            $user->setResetPasswordToken($token);
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Hey coco, va checker tes mails ;)');

            return $this->redirectToRoute('login');
        }

        // Render
        return $this->render('site/forgotpassword.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * This route shows change password page.
     * @Route("/changer-mon-mot-de-passe/{token}", name="changepassword")
     */
    public function changePassAction(Request $request, string $token)
    {
        /** @var User $user */
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['resetPasswordToken' => $token]);
        if (!$user) {
            $this->addFlash('error', 'raté');
            return $this->redirectToRoute('login');
        }

        // Create the form
        $form = $this->createForm(PasswordResetType::class, $user);

        // Post request
        $form->handleRequest($request);

        // Token logic
        if ($form->isSubmitted() && $form->isValid()) {
            $encoder = $this->factory->getEncoder(User::class);
            $user->setPassword($encoder->encodePassword($user->getPlainPassword(), $user->getSalt()));
            $user->eraseCredentials();
            $user->setResetPasswordToken(null);

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Mot de passe mis à jour avec succès');

            return $this->redirectToRoute('login');
        }

        // Render
        return $this->render('site/changepassword.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
