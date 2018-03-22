<?php

namespace App\Event;

use App\Entity\Exhibit;
use App\Entity\Party;
use App\Entity\Weekend;
use JavierEguiluz\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class MailEventSubscriber implements EventSubscriberInterface
{
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents()
    {
        return [
            EasyAdminEvents::POST_PERSIST => 'onPostPersist',
            EasyAdminEvents::POST_UPDATE => 'onPostUpdate',
            EasyAdminEvents::POST_REMOVE => 'onPostRemove'
        ];
    }

    // When new event is created

    public function onPostPersist(GenericEvent $event) {

        $entity = $event->getSubject();

        if($entity instanceof Party
            || $entity instanceof Exhibit
                || $entity instanceof Weekend) {

            $message = (new \Swift_Message('Votre BDE organise un nouvel événement: '. $entity->getname()))
                ->setFrom('projectcheval@gmail.com')
                ->setTo('belabesmohammed@gmail.com')
                ->setBody(
                    $entity->getName().
                            $entity->getLocation().
                                $entity->getprice()
                )
            ;

            $this->mailer->send($message);
        }
    }

    // When event is updated

    public function onPostUpdate(GenericEvent $event) {

        $entity = $event->getSubject();

        if($entity instanceof Party
            || $entity instanceof Exhibit
            || $entity instanceof Weekend) {

            $message = (new \Swift_Message('Un événement a été modifié: '. $entity->getname()))
                ->setFrom('projectcheval@gmail.com')
                ->setTo('belabesmohammed@gmail.com')
                ->setBody(
                    $entity->getName().
                    $entity->getLocation().
                    $entity->getprice()
                )
            ;

            $this->mailer->send($message);
        }
    }

    // When event is deleted (on peut plus se bourrer la gueule quoi)

    public function onPostRemove(GenericEvent $event) {

        $entity = $event->getSubject();

        if($entity instanceof Party
            || $entity instanceof Exhibit
            || $entity instanceof Weekend) {

            $message = (new \Swift_Message('Un événement a été annulé :( '. $entity->getname()))
                ->setFrom('projectcheval@gmail.com')
                ->setTo('belabesmohammed@gmail.com')
                ->setBody(
                    $entity->getName().
                    $entity->getLocation().
                    $entity->getprice()
                )
            ;

            $this->mailer->send($message);
        }
    }

}