<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UsersController extends Controller
{
    /**
     * @Route("/equipe", name="team")
     */
    public function teamAction(UserRepository $userRepository)
    {
        $teamMembers = $userRepository->getTeamMembers();

        return $this->render('site/equipe.html.twig', [
            'controller_name' => 'UsersController',
            'teamMembers' => $teamMembers
        ]);
    }
}
