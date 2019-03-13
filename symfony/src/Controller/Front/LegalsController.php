<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LegalsController
 */
class LegalsController extends AbstractController
{

    /**
     * @Route("/cookie-policy", name="cookie-policy")
     */
    public function cookiePolicy()
    {
        return $this->render('cookie-policy.html.twig', []);
    }

    /**
     * @Route("/general-terms", name="general-terms")
     */
    public function generalConditions()
    {
        return $this->render('terms.html.twig', []);
    }
}