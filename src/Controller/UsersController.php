<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
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

    /**
     * @Route("/profil", name="profil")
     */
    public function getUserData(UserRepository $userRepository)
    {
        // Check is a user is logged in
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // Set the user
        $user = $this->getUser();

        // Get user data
        $userName = $user->getUserName();
        $userFirstName = $user->getFirstName();
        $userLastName = $user->getLastName();
        $userEmail = $user->getEmail();
        $userAvatar = $user->getAvatar();

        // Get user events subscription
        $isUserExhibit = $user->getExhibit();
        $isUserParty = $user->getParty();
        $isUserWeekend = $user->getWeekend();

        // Get user events follow
        // Convert object into array
        $userExhibitFollow = $user->getExhibitFollow()->toArray();
        $userPartyFollow = $user->getPartyFollow()->toArray();
        $userWeekendFollow = $user->getWeekendFollow()->toArray();

        // Concatenate events follow into a single array
        $userEventsFollow = new ArrayCollection(
            array_merge(
                $userExhibitFollow,
                $userPartyFollow,
                $userWeekendFollow
            )
        );

        return $this->render('site/profil.html.twig', [
            'controller_name' => 'UsersController',
            'user' => $user,
            'userName' => $userName,
            'userFirstName' => $userFirstName,
            'userLastName' => $userLastName,
            'userEmail' => $userEmail,
            'userAvatar' => $userAvatar,
            'isUserExhibit' => $isUserExhibit,
            'isUserParty' => $isUserParty,
            'isUserWeekend' => $isUserWeekend,
            'userEventsFollow' => $userEventsFollow
        ]);
    }
}
