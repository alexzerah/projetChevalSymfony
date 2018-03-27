<?php

namespace App\Event;

use App\Entity\Exhibit;
use App\Entity\Party;
use App\Entity\User;
use App\Entity\Weekend;
use App\Repository\UserRepository;
use JavierEguiluz\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class MailEventSubscriber implements EventSubscriberInterface
{
    private $mailer;
    private $userRepository;
    private $templating;

    /*
     * Get users emails and put 'em in an array
     */
    protected function getUsersEmails($users)
    {
        $userEmail = [];

        foreach ($users as $user) {
            $userEmail[] = $user->email;
        }

        return $userEmail;
    }

    public static function getSubscribedEvents()
    {
        return [
            EasyAdminEvents::POST_PERSIST => 'onPostPersist',
            EasyAdminEvents::POST_UPDATE => 'onPostUpdate',
            EasyAdminEvents::PRE_REMOVE => 'onPreRemove'
        ];
    }

    /*
     * Hook fires when event has been created
     */
    public function onPostPersist(GenericEvent $event)
    {
        $entity = $event->getSubject();

            // Résoi
            if ($entity instanceof Party) {

                // Custom DQL
                $users = $this->userRepository->getUsersFollowingParties();

                try {
                    $message = (new \Swift_Message('Votre BDE organise une soirée : (' . $entity->getname() . ')'))
                        ->setFrom('projectcheval@gmail.com')
                        ->setTo($this->getUsersEmails($users))
                        ->setBody(
                            $this->templating->render(
                                'mails/eventcreated.html.twig',
                                array(
                                    'name' => $entity->getName(),
                                    'location' => $entity->getLocation(),
                                    'price' => $entity->getPrice(),
                                    'date' => $entity->getDate(),
                                    'details' => $entity->getDetails(),
                                    'banner' => $entity->getBanner()
                                )
                            ),
                            'text/html'
                        );
                } catch (\Twig_Error_Loader $e) {
                    return $e;
                } catch (\Twig_Error_Runtime $e) {
                    return $e;
                } catch (\Twig_Error_Syntax $e) {
                    return $e;
                }

                $this->mailer->send($message);

                // Expo
            } elseif ($entity instanceof Exhibit) {

                // Custom DQL
                $users = $this->userRepository->getUsersFollowingExhibits();

                try {
                    $message = (new \Swift_Message('Votre BDE organise une exposition : (' . $entity->getname() . ')'))
                        ->setFrom('projectcheval@gmail.com')
                        ->setTo($this->getUsersEmails($users))
                        ->setBody(
                            $this->templating->render(
                                'mails/eventcreated.html.twig',
                                array(
                                    'name' => $entity->getName(),
                                    'location' => $entity->getLocation(),
                                    'price' => $entity->getPrice(),
                                    'date' => $entity->getDate(),
                                    'details' => $entity->getDetails(),
                                    'banner' => $entity->getBanner()
                                )
                            ),
                            'text/html'
                        );
                } catch (\Twig_Error_Loader $e) {
                    return $e;
                } catch (\Twig_Error_Runtime $e) {
                    return $e;
                } catch (\Twig_Error_Syntax $e) {
                    return $e;
                }

                $this->mailer->send($message);

                // Weekend
            } elseif ($entity instanceof Weekend) {

                // Custom DQL
                $users = $this->userRepository->getUsersFollowingWeekends();

                try {
                    $message = (new \Swift_Message('Votre BDE organise un weekend : (' . $entity->getname() . ')'))
                        ->setFrom('projectcheval@gmail.com')
                        ->setTo($this->getUsersEmails($users))
                        ->setBody(
                            $this->templating->render(
                                'mails/eventcreated.html.twig',
                                array(
                                    'name' => $entity->getName(),
                                    'location' => $entity->getLocation(),
                                    'price' => $entity->getPrice(),
                                    'date' => $entity->getDate(),
                                    'details' => $entity->getDetails(),
                                    'banner' => $entity->getBanner()
                                )
                            ),
                            'text/html'
                        );
                } catch (\Twig_Error_Loader $e) {
                    return $e;
                } catch (\Twig_Error_Runtime $e) {
                    return $e;
                } catch (\Twig_Error_Syntax $e) {
                    return $e;
                }

                $this->mailer->send($message);

            } else {
                return false;
            }

        return false;
    }

    /*
     * Hook fires when event has been updated
     */
    public function onPostUpdate(GenericEvent $event)
    {
        $entity = $event->getSubject();

        if ($entity instanceof Party || $entity instanceof Exhibit || $entity instanceof Weekend) {

            $users = $entity->getUsers()->toArray();

            try {
                $message = (new \Swift_Message('Un événement a été modifié: ' . $entity->getname()))
                    ->setFrom('projectcheval@gmail.com')
                    ->setTo($this->getUsersEmails($users))
                    ->setBody(
                        $this->templating->render(
                            'mails/eventupdated.html.twig',
                            array(
                                'name' => $entity->getName(),
                                'location' => $entity->getLocation(),
                                'price' => $entity->getPrice(),
                                'date' => $entity->getDate(),
                                'details' => $entity->getDetails(),
                                'banner' => $entity->getBanner()
                            )
                        ),
                        'text/html'
                    );
            } catch (\Twig_Error_Loader $e) {
                return $e;
            } catch (\Twig_Error_Runtime $e) {
                return $e;
            } catch (\Twig_Error_Syntax $e) {
                return $e;
            };

            $this->mailer->send($message);
        }

        return false;
    }

    /*
     * Hook fires when event is going to be removed
     * onPreRemove cuz we need to send info mail before we delete it
     */
    public function onPreRemove(GenericEvent $event)
    {
        $entity = $event->getSubject();

        if ($entity instanceof Party || $entity instanceof Exhibit || $entity instanceof Weekend) {

            $users = $entity->getUsers()->toArray();

            try {
                $message = (new \Swift_Message('L \' événement (' . $entity->getname() . ') a été annulé...'))
                    ->setFrom('projectcheval@gmail.com')
                    ->setTo($this->getUsersEmails($users))
                    ->setBody(
                        $this->templating->render(
                            'mails/eventcanceled.html.twig',
                            array(
                                'name' => $entity->getName(),
                                'location' => $entity->getLocation(),
                                'price' => $entity->getPrice(),
                                'date' => $entity->getDate(),
                                'details' => $entity->getDetails(),
                                'banner' => $entity->getBanner()
                            )
                        ),
                        'text/html'
                    );
            } catch (\Twig_Error_Loader $e) {
                return $e;
            } catch (\Twig_Error_Runtime $e) {
                return $e;
            } catch (\Twig_Error_Syntax $e) {
                return $e;
            };

            $this->mailer->send($message);
        }

        return false;
    }

    /*
     * Init
     */
    public function __construct(\Twig_Environment $templating, UserRepository $userRepository, \Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
        $this->userRepository = $userRepository;
        $this->templating = $templating;
    }
}
