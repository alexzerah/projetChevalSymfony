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
            EasyAdminEvents::PRE_PERSIST => 'onPrePersist'
        ];
    }

    public function onPrePersist(GenericEvent $event) {

        $entity = $event->getSubject();

        if($entity instanceof Party
            || $entity instanceof Exhibit
                || $entity instanceof Weekend) {

            $message = (new \Swift_Message('Votre BDE organise un nouvel évènement: '. $entity->getname()))
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