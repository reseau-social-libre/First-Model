<?php

declare(strict_types=1);

namespace App\Controller\Front;

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
     * @Route("/my-profile", name="my-profile")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request): Response
    {

        return $this->render('profile/index.html.twig', []);
    }
}
