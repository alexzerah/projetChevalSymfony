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
     * @Route("/soirees", name="events_soirees")
     */
    public function afficheListeSoirees(PartyRepository $soireeRepository)
    {

        $soirees = $soireeRepository->findAll();

        return $this->render('events\soirees.html.twig', [
            'controller_name' => 'EventsController',
            'soirees' => $soirees
        ]);
    }

    /**
     * @Route("/soiree/{nom}", name="events_soiree")
     */
    public function afficheSoiree(PartyRepository $soireeRepository, $nom)
    {

        $soiree = $soireeRepository->findOneBy(array('nom' => $nom));

        return $this->render('events\soiree.html.twig', [
            'controller_name' => 'EventsController',
            'soiree' => $soiree
        ]);
    }

    /**
     * @Route("/weekends", name="events_weekends")
     */
    public function afficheListeWeekends(WeekendRepository $weekendRepository)
    {

        $weekends = $weekendRepository->findAll();

        return $this->render('events\weekends.html.twig', [
            'controller_name' => 'EventsController',
            'weekends' => $weekends
        ]);
    }

    /**
     * @Route("/weekend/{nom}", name="events_weekend")
     */
    public function afficheWeekend(WeekendRepository $weekendRepository, $nom)
    {

        $weekend = $weekendRepository->findOneBy(array('nom' => $nom));

        return $this->render('events\weekend.html.twig', [
            'controller_name' => 'EventsController',
            'weekend' => $weekend
        ]);
    }

     /**
     * @Route("/expositions", name="events_exposiitons")
     */
    public function afficheListeExpositions(ExhibitRepository $expositionRepository)
    {

        $expositions = $expositionRepository->findAll();

        return $this->render('events\expositions.html.twig', [
            'controller_name' => 'EventsController',
            'expositions' => $expositions
        ]);
    }

    /**
     * @Route("/exposition/{nom}", name="events_exposition")
     */
    public function afficheExposition(ExhibitRepository $expositionRepository, $nom)
    {

        $exposition = $expositionRepository->findOneBy(array('nom' => $nom));

        return $this->render('events\exposition.html.twig', [
            'controller_name' => 'EventsController',
            'exposition' => $exposition
        ]);
    }

    /**
     * @Route("/fetch/", name="events_fetch")
     */
    public function getLatestEvents(WeekendRepository $weekendRepository,
                                      PartyRepository $partyRepository,
                                        ExhibitRepository $exhibitRepository)
    {
        $latestWeekends = $weekendRepository->getLatestWeekends();
        $latestParties = $partyRepository->getLatestParties();
        $latestExhibits = $exhibitRepository->getLatestExhibits();

        return $this->render('site\latest.html.twig', [
            'controller_name' => 'EventsController',
            'latestWeekends' => $latestWeekends,
            'latestParties' => $latestParties,
            'latestExhibits' => $latestExhibits
        ]);
    }

}
