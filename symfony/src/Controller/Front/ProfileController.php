<?php

declare(strict_types=1);

namespace App\Controller\Front;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProfileController
 */
class ProfileController extends AbstractController
{

    /**
     * Show a user profile.
     *
     * @Route("/profile/{username}", name="profile")
     *
     * @param Request $request
     * @param string  $username
     *
     * @return Response
     */
    public function index(Request $request, string $username): Response
    {

        // Check if user profile is the current logged in user.
        if ($username == $this->getUser()->getUsername()) {
            $user = $this->getUser();
        } else {
            $userRepository = $this->getDoctrine()->getRepository(User::class);
            $user = $userRepository->findOneBy([
               'username' => $username,
            ]);
        }

        return $this->render('profile/index.html.twig', ['user' => $user]);
    }
}
