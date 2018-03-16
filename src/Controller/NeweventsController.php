<?php

namespace App\Controller;

use App\Repository\ExhibitRepository;
use App\Repository\PartyRepository;
use App\Repository\WeekendRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NeweventsController extends Controller
{
    /**
     * @Route("/events", name="events")
     */
    public function listeEvent(PartyRepository $partyRepository, WeekendRepository $weekendRepository,ExhibitRepository $exhibitRepository )
    {
        $party = $partyRepository->findAll();
        $exhibit = $exhibitRepository->findAll();
        $weekends = $weekendRepository->findAll();

        return $this->render('events.html.twig', [
            'party' => $party,
            'exhibit' => $exhibit,
            'weekends' => $weekends,
        ]);
    }


}
