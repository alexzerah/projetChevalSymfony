<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UsersController extends Controller
{
    /**
     * @Route("/equipe", name="equipe")
     */
    public function teamAction()
    {
        return $this->render('site/equipe.html.twig', [
            'controller_name' => 'UsersController',
        ]);
    }
}
