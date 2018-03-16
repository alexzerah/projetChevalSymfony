<?php

namespace App\Controller;

use App\Repository\ExhibitRepository;
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

        $party = $partyRepository->findOneBy(array('nom' => $name));
        $weekend = $weekendRepository->findOneBy(array('nom' => $name));
        $exhibit = $exhibitRepository->findOneBy(array('nom' => $name));

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

}
