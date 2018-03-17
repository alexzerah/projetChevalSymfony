<?php

namespace App\Controller;

use App\Repository\ExhibitRepository;
use App\Repository\FetchRepository;
use App\Repository\PartyRepository;
use App\Repository\WeekendRepository;
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

        $party = $partyRepository->getTheParty($name);
        $weekend = $weekendRepository->getTheWeekend($name);
        $exhibit = $exhibitRepository->getTheExhibit($name);

        return $this->render('site\event.html.twig', [
            'controller_name' => 'EventsController',
            'party' => $party,
            'weekend' => $weekend,
            'exhibit' => $exhibit
        ]);
    }

    /**
     * @Route("/", name="events_latestEvents")
     */
    public function getLatestEvents(WeekendRepository $weekendRepository,
                                      PartyRepository $partyRepository,
                                        ExhibitRepository $exhibitRepository)
    {
        $latestWeekends = $weekendRepository->getNextWeekends();
        $latestParties = $partyRepository->getNextParties();
        $latestExhibits = $exhibitRepository->getNextExhibits();

        return $this->render('site\home.html.twig', [
            'controller_name' => 'EventsController',
            'latestWeekends' => $latestWeekends,
            'latestParties' => $latestParties,
            'latestExhibits' => $latestExhibits
        ]);
    }

    /**
     * @Route("/listeEvenements", name="events_oldEvents")
     */
    public function getOldEvents(WeekendRepository $weekendRepository,
                                    PartyRepository $partyRepository,
                                    ExhibitRepository $exhibitRepository)
    {
        $oldWeekends = $weekendRepository->getPreviousWeekends();
        $oldParties = $partyRepository->getPreviousParties();
        $oldExhibits = $exhibitRepository->getPreviousExhibits();

        return $this->render('site\listeEvent.html.twig', [
            'controller_name' => 'EventsController',
            'oldWeekends' => $oldWeekends,
            'oldParties' => $oldParties,
            'oldExhibits' => $oldExhibits
        ]);
    }

}
