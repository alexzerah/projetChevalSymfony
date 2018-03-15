<?php

namespace App\Controller;

use App\Repository\SoireeRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EventsController extends Controller
{
    /**
     * @Route("/soiree", name="events_soiree")
     */
    public function soireeAction(SoireeRepository $soireeRepository)
    {

        $soirees = $soireeRepository->findAll();

        return $this->render('events\soirees.html.twig', [
            'controller_name' => 'EventsController',
            'soirees' => $soirees
        ]);
    }
}
