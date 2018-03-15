<?php

namespace App\Controller;

use App\Repository\SoireeRepository;
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
}
