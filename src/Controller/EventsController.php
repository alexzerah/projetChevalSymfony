<?php

namespace App\Controller;

use App\Repository\ExhibitRepository;
use App\Repository\LatestRepository;
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

        $party = $partyRepository->findOneBy(array('name' => $name));
        $weekend = $weekendRepository->findOneBy(array('name' => $name));
        $exhibit = $exhibitRepository->findOneBy(array('name' => $name));

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
        $latestWeekends = $weekendRepository->getLatestWeekends();
        $latestParties = $partyRepository->getLatestParties();
        $latestExhibits = $exhibitRepository->getLatestExhibits();

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
        $oldWeekends = $weekendRepository->getOldWeekends();
        $oldParties = $partyRepository->getOldParties();
        $oldExhibits = $exhibitRepository->getOldExhibits();

        return $this->render('site\listeEvent.html.twig', [
            'controller_name' => 'EventsController',
            'oldWeekends' => $oldWeekends,
            'oldParties' => $oldParties,
            'oldExhibits' => $oldExhibits
        ]);
    }

    /**
     * @Route("/fetch", name="events_caca")
     */
    public function fetchEvents(LatestRepository $latestRepository)
    {

        $fetch = $latestRepository->findTest();

        return $this->render('site\latest.html.twig', [
            'controller_name' => 'EventsController',
            'fetch' => $fetch
        ]);
    }

}
