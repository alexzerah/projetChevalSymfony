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

    public function __construct(\Twig_Environment $templating, UserRepository $userRepository, \Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
        $this->userRepository = $userRepository;
        $this->templating = $templating;
    }

    public static function getSubscribedEvents()
    {
        return [
            EasyAdminEvents::POST_PERSIST => 'onPostPersist',
            EasyAdminEvents::POST_UPDATE => 'onPostUpdate',
            EasyAdminEvents::PRE_REMOVE => 'onPreRemove'
        ];
    }

    // When new event is created

    public function onPostPersist(GenericEvent $event) {

        $entity = $event->getSubject();

        if($entity instanceof Party
            || $entity instanceof Exhibit
            || $entity instanceof Weekend) {

            if($entity instanceof Party) {

                $users = $this->userRepository->getUsersFollowingParties();

                try {
                    $message = (new \Swift_Message('Votre BDE organise une nouvelle soirée ' . $entity->getname()))
                        ->setFrom('projectcheval@gmail.com')
                        ->setTo($this->emailsArray($users))
                        ->setBody(
                            $this->templating->render(
                                'mails/eventcreated.html.twig',
                                array(
                                    'name' => $entity->getName(),
                                    'location' => $entity->getLocation(),
                                    'price' => $entity->getPrice(),
                                    'date' => $entity->getDate(),
                                    'details' => $entity->getDetails(),
                                    'banner' => $entity->getBanner(),
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

            } else if($entity instanceof Exhibit) {
                $users = $this->userRepository->getUsersFollowingExhibits();

                try {
                    $message = (new \Swift_Message('Votre BDE organise une nouvelle soirée ' . $entity->getname()))
                        ->setFrom('projectcheval@gmail.com')
                        ->setTo($this->emailsArray($users))
                        ->setBody(
                            $this->templating->render(
                                'mails/eventcreated.html.twig',
                                array(
                                    'name' => $entity->getName(),
                                    'location' => $entity->getLocation(),
                                    'price' => $entity->getPrice(),
                                    'date' => $entity->getDate(),
                                    'details' => $entity->getDetails(),
                                    'banner' => $entity->getBanner(),
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
                $users = $this->userRepository->getUsersFollowingWeekends();

                try {
                    $message = (new \Swift_Message('Votre BDE organise une nouvelle soirée ' . $entity->getname()))
                        ->setFrom('projectcheval@gmail.com')
                        ->setTo($this->emailsArray($users))
                        ->setBody(
                            $this->templating->render(
                                'mails/eventcreated.html.twig',
                                array(
                                    'name' => $entity->getName(),
                                    'location' => $entity->getLocation(),
                                    'price' => $entity->getPrice(),
                                    'date' => $entity->getDate(),
                                    'details' => $entity->getDetails(),
                                    'banner' => $entity->getBanner(),
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
            }
        }

        return false;
    }

    // When event is updated

    public function onPostUpdate(GenericEvent $event) {

        $entity = $event->getSubject();

        if($entity instanceof Party
            || $entity instanceof Exhibit
            || $entity instanceof Weekend) {

            $users = $entity->getUsers()->toArray();

            $userEmail = [];
            foreach($users as $user) {
                $userEmail[] = $user->email;
            }

            try {
                $message = (new \Swift_Message('Un événement a été modifié: ' . $entity->getname()))
                    ->setFrom('projectcheval@gmail.com')
                    ->setTo($userEmail)
                    ->setBody(
                        $this->templating->render(
                            'mails/eventupdated.html.twig',
                            array(
                                'name' => $entity->getName(),
                                'location' => $entity->getLocation(),
                                'price' => $entity->getPrice(),
                                'date' => $entity->getDate(),
                                'details' => $entity->getDetails(),
                                'banner' => $entity->getBanner(),
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

    // When event is deleted (on peut plus se bourrer la gueule quoi)

    public function onPreRemove(GenericEvent $event) {

        $entity = $event->getSubject();

        if($entity instanceof Party
            || $entity instanceof Exhibit
            || $entity instanceof Weekend) {

            $users = $entity->getUsers()->toArray();

            $userEmail = [];
            foreach($users as $user) {
                $userEmail[] = $user->email;
            }

            try {
                $message = (new \Swift_Message('Un événement a été annulé :( ! ' . $entity->getname()))
                    ->setFrom('projectcheval@gmail.com')
                    ->setTo($userEmail)
                    ->setBody(
                        $this->templating->render(
                            'mails/eventcanceled.html.twig',
                            array(
                                'name' => $entity->getName(),
                                'location' => $entity->getLocation(),
                                'price' => $entity->getPrice(),
                                'date' => $entity->getDate(),
                                'details' => $entity->getDetails(),
                                'banner' => $entity->getBanner(),
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

    protected function emailsArray($users) {
        $userEmail = [];
        foreach($users as $user) {
            $userEmail[] = $user->email;
        }

        return $userEmail;
    }

}