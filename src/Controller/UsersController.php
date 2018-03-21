<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
use App\Repository\UserRepository;
use App\Services\Concatenate;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    public function userProfil(Request $request, Concatenate $concatenate)
    {
        // Check is a user is logged in
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // Set the user
        $user = $this->getUser();

        // Get user events follow
        $userExhibitFollow = $user->getExhibitFollow()->toArray();
        $userPartyFollow = $user->getPartyFollow()->toArray();
        $userWeekendFollow = $user->getWeekendFollow()->toArray();

        // Call concatenate service
        $userEventsFollow = $concatenate->doConcatenate(
            $userPartyFollow,
            $userExhibitFollow,
            $userWeekendFollow
        );

        // user form update
        $form = $this->createForm(UserFormType::class, $user);

        // handles data from POST requests
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $theUser = $form->getData();

                $em = $this->getDoctrine()->getManager();

                // Petit hack pour mettre à jour la photo de profil sans modifier un autre champs
                // dégueux mais j'ai pas mieux
                $user->setUpdatedAt(new \DateTime());

                $em->persist($theUser);
                $em->flush();

            } else {
                return array(
                    'data' => 'prout'
                );
            }
        }

        return $this->render('site/profil.html.twig', [
            'controller_name' => 'UsersController',
            'userForm' => $form->createView(),
            'userEventsFollow' => $userEventsFollow
        ]);
    }
}
