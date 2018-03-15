<?php

namespace App\Controller;

use App\Repository\SoireeRepository;
use App\Repository\WeekendRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EventsController extends Controller
{
    /**
     * @Route("/soirees", name="events_soirees")
     */
    public function afficheListeSoirees(SoireeRepository $soireeRepository)
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
    public function afficheSoiree(SoireeRepository $soireeRepository, $nom)
    {

        $soiree = $soireeRepository->findOneBy(array('nomSoiree' => $nom));

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
}
