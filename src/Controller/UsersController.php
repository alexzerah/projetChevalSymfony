<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
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
    public function userProfil(Request $request)
    {
        // Check is a user is logged in
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // Set the user
        $user = $this->getUser();

        // Get user events follow
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

        // user form update
        $form = $this->createForm(UserFormType::class, $user);

        // handles data from POST requests
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $theUser = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($theUser);
            $em->flush();

            $this->addFlash('success', 'Profil mis à jour :)');

            return $this->redirectToRoute('profil');
        }

        return $this->render('site/profil.html.twig', [
            'controller_name' => 'UsersController',
            'userForm' => $form->createView(),
            'userEventsFollow' => $userEventsFollow
        ]);
    }
}
