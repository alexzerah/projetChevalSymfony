<?php

namespace App\Controller;

use App\Entity\Exhibit;
use App\Entity\Party;
use App\Entity\Weekend;
use App\Form\SubscribeSingleExhibit;
use App\Form\UnsubscribeSingleExhibit;
use App\Form\UserFormType;
use App\Repository\ExhibitRepository;
use App\Repository\PartyRepository;
use App\Repository\UserRepository;
use App\Repository\WeekendRepository;
use App\Services\Concatenate;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class EventsController extends Controller
{
    /**
     * @Route("/event/{name}", name="events_event"),
     */
    public function showEvent(WeekendRepository $weekendRepository,
                              PartyRepository $partyRepository,
                              ExhibitRepository $exhibitRepository,
                              UserRepository $userRepository,
                              $name)
    {
        // Call the function that give us one event based on the name for each entities
        $theParty = $partyRepository->getTheParty($name);
        $theWeekend = $weekendRepository->getTheWeekend($name);
        $theExhibit = $exhibitRepository->getTheExhibit($name);

        // Check if no wrong event has been provided
        if (!$theParty && !$theWeekend && !$theExhibit) {
            throw $this->createNotFoundException('Aucun événement trouvé !');
        }

        return $this->render('site\event.html.twig', [
            'party' => $theParty,
            'weekend' => $theWeekend,
            'exhibit' => $theExhibit,
        ]);
    }

    /**
     * @Route("/event", name="event_home"),
     */
    public function eventNotFound()
    {
        throw $this->createNotFoundException('Aucun événement trouvé !');
    }

    /**
     * @Route("/", name="events_nextEvents")
     */
    public function getNextEvents(WeekendRepository $weekendRepository,
                                      PartyRepository $partyRepository,
                                        ExhibitRepository $exhibitRepository,
                                            Concatenate $concatenate)
    {
        // Call the function that give us events when event.date > today for each entities
        $nextWeekends = $weekendRepository->getNextWeekends();
        $nextParties = $partyRepository->getNextParties();
        $nextExhibits = $exhibitRepository->getNextExhibits();

        // Call concatenate service
        $nextEvents = $concatenate->doConcatenate(
            $nextWeekends,
            $nextParties,
            $nextExhibits
        );

        return $this->render('site\home.html.twig', [
            'controller_name' => 'EventsController',
            'nextEvents' => $nextEvents,
        ]);
    }

    /**
     * @Route("/listeEvenements", name="events_previousEvents")
     */
    public function getPreviousEvents(WeekendRepository $weekendRepository,
                                        PartyRepository $partyRepository,
                                            ExhibitRepository $exhibitRepository,
                                                Concatenate $concatenate)
    {
        // Call the function that give us events when event.date < today for each entities
        $previousWeekends = $weekendRepository->getPreviousWeekends();
        $previousParties = $partyRepository->getPreviousParties();
        $previousExhibits = $exhibitRepository->getPreviousExhibits();

        // Call concatenate service
        $previousEvents = $concatenate->doConcatenate(
            $previousWeekends,
            $previousParties,
            $previousExhibits
        );

        return $this->render('site\listeEvent.html.twig', [
            'controller_name' => 'EventsController',
            'previousEvents' => $previousEvents,
        ]);
    }

    /**
     * @Route("/evenement/inscription/{eventType}", name="event_subscribe")
     */
    public function subscribeEventAction(Request $request, string $eventType)
    {
        switch ($eventType) {
            case 'exhibit':
                $repository = $this->getDoctrine()->getRepository(Exhibit::class);
                break;
            case 'party':
                $repository = $this->getDoctrine()->getRepository(Party::class);
                break;
            case 'weekend':
                $repository = $this->getDoctrine()->getRepository(Weekend::class);
                break;
        }

        $event = $repository->find($request->get('eventId'));

        if ($event instanceof Exhibit || $event instanceof Party || $event instanceof Weekend) {
            $event->addUser($this->getUser());
            $this->getDoctrine()->getManager()->persist($event);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('events_event', ['name' => $event->getName()]);
        } else {
            throw $this->createNotFoundException('Aucun événement trouvé !');
        }
    }

    /**
     * @Route("/evenement/desinscription/{eventType}", name="event_unsubscribe")
     */
    public function unsubscribeEventAction(Request $request, string $eventType)
    {
        switch ($eventType) {
            case 'exhibit':
                $repository = $this->getDoctrine()->getRepository(Exhibit::class);
                break;
            case 'party':
                $repository = $this->getDoctrine()->getRepository(Party::class);
                break;
            case 'weekend':
                $repository = $this->getDoctrine()->getRepository(Weekend::class);
                break;
        }

        $event = $repository->find($request->get('eventId'));

        if ($event instanceof Exhibit || $event instanceof Party || $event instanceof Weekend) {
            $event->removeUser($this->getUser());
            $this->getDoctrine()->getManager()->persist($event);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('events_event', ['name' => $event->getName()]);
        } else {
            throw $this->createNotFoundException('Aucun événement trouvé !');
        }
    }
}
