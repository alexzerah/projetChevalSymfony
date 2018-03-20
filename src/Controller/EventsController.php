<?php

namespace App\Controller;

use App\Form\UserSubscribeFormType;
use App\Repository\ExhibitRepository;
use App\Repository\PartyRepository;
use App\Repository\WeekendRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EventsController extends Controller
{
    /**
     * @Route("/event/{name}", name="events_event")
     */
    public function showEvent(WeekendRepository $weekendRepository,
                              PartyRepository $partyRepository,
                              ExhibitRepository $exhibitRepository,
                              $name)
    {
        // Check is a user is logged in
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // Set the user
        $user = $this->getUser();

        // user form update
        $form = $this->createForm(UserSubscribeFormType::class, $user);

        // Call the function that give us one event based on the name for each entities
        $theParty = $partyRepository->getTheParty($name);
        $theWeekend = $weekendRepository->getTheWeekend($name);
        $theExhibit = $exhibitRepository->getTheExhibit($name);

        return $this->render('site\event.html.twig', [
            'controller_name' => 'EventsController',
            'party' => $theParty,
            'weekend' => $theWeekend,
            'exhibit' => $theExhibit,
            'userSubscribeForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/", name="events_nextEvents")
     */
    public function getNextEvents(WeekendRepository $weekendRepository,
                                      PartyRepository $partyRepository,
                                        ExhibitRepository $exhibitRepository)
    {
        // Call the function that give us events when event.date > today for each entities
        $nextWeekends = $weekendRepository->getNextWeekends();
        $nextParties = $partyRepository->getNextParties();
        $nextExhibits = $exhibitRepository->getNextExhibits();

        // Concatenate these arrays into one single array
        $nextEvents = new ArrayCollection(
            array_merge(
                $nextWeekends,
                $nextParties,
                $nextExhibits
            )
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
                                    ExhibitRepository $exhibitRepository)
    {
        // Call the function that give us events when event.date < today for each entities
        $previousWeekends = $weekendRepository->getPreviousWeekends();
        $previousParties = $partyRepository->getPreviousParties();
        $previousExhibits = $exhibitRepository->getPreviousExhibits();

        // Concatenate these arrays into one single array
        $previousEvents = new ArrayCollection(
            array_merge(
                $previousWeekends,
                $previousParties,
                $previousExhibits
            )
        );

        return $this->render('site\listeEvent.html.twig', [
            'controller_name' => 'EventsController',
            'previousEvents' => $previousEvents,
        ]);
    }

}
