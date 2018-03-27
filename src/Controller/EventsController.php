<?php

namespace App\Controller;

use App\Entity\Exhibit;
use App\Entity\Party;
use App\Entity\Weekend;
use App\Repository\ExhibitRepository;
use App\Repository\PartyRepository;
use App\Repository\WeekendRepository;
use App\Services\Merge;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class EventsController extends Controller
{
    // Setup
    private $partyRepository;
    private $exhibitRepository;
    private $weekendRepository;
    private $merge;

    // Constructor
    public function __construct(PartyRepository $partyRepository, ExhibitRepository $exhibitRepository, WeekendRepository $weekendRepository, Merge $merge)
    {
        $this->partyRepository = $partyRepository;
        $this->weekendRepository = $weekendRepository;
        $this->exhibitRepository = $exhibitRepository;
        $this->merge = $merge;
    }

    /**
     * 404 handler.
     * @Route("/event", name="event_index"),
     */
    public function eventNotFoundAction()
    {
        throw $this->createNotFoundException('Did you mean /event/the-event-name ?');
    }

    /**
     * This route shows upcoming events list
     * @Route("/", name="events_upcoming")
     * @Route("/", name="home")
     */
    public function upcomingEventsAction()
    {
        // Custom queries : find upcoming events
        $upcomingParties = $this->partyRepository->getUpcomingParties();
        $upcomingExhibits = $this->exhibitRepository->getUpcomingExhibits();
        $upcomingWeekends = $this->weekendRepository->getUpcomingWeekends();

        // Merge for easy listing
        $upcomingEvents = $this->merge->mergeAction(
            $upcomingWeekends,
            $upcomingParties,
            $upcomingExhibits
        );

        // Render
        return $this->render('site\home.html.twig', [
            'controller_name' => 'EventsController',
            'upcomingEvents' => $upcomingEvents,
        ]);
    }

    /**
     * This route shows previous events list.
     * @Route("/previous-events", name="events_previous")
     */
    public function previousEventsAction()
    {
        // // Custom queries : find outdated events
        $previousParties = $this->partyRepository->getPreviousParties();
        $previousExhibits = $this->exhibitRepository->getPreviousExhibits();
        $previousWeekends = $this->weekendRepository->getPreviousWeekends();

        // Merge for easy listing
        $previousEvents = $this->merge->mergeAction(
            $previousWeekends,
            $previousParties,
            $previousExhibits
        );

        // Render
        return $this->render('site\eventsprevious.html.twig', [
            'controller_name' => 'EventsController',
            'previousEvents' => $previousEvents,
        ]);
    }

    /**
     * This route shows event data.
     * @Route("/event/{slug}", name="event_show"),
     */
    public function showEventAction($slug)
    {
        // Custom queries : find event where slug = $slug
        $theParty = $this->partyRepository->getParty($slug);
        $theExhibit = $this->exhibitRepository->getExhibit($slug);
        $theWeekend = $this->weekendRepository->getWeekend($slug);

        // If no event found throw 404
        if (!$theParty && !$theWeekend && !$theExhibit) {
            throw $this->createNotFoundException('Event not found');
        }

        // Render : event.html.twig
        return $this->render('site\event.html.twig', [
            'party' => $theParty,
            'weekend' => $theWeekend,
            'exhibit' => $theExhibit
        ]);
    }

    /**
     * This route do user subscription to an event.
     * @Route("/evenement/subscribe/{eventType}", name="event_subscribe")
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
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('event_show', ['slug' => $event->getSlug()]);
        } else {
            throw $this->createNotFoundException('Event not found');
        }
    }

    /**
     * * This route do user unsubscription to an event.
     * @Route("/evenement/unsubscribe/{eventType}", name="event_unsubscribe")
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
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('event_show', ['slug' => $event->getSlug()]);
        } else {
            throw $this->createNotFoundException('Event not found');
        }
    }
}
