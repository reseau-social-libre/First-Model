<?php

declare(strict_types=1);

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LiveController
 */
class LiveController extends AbstractController
{

    /**
     * @Route("post/live/publish", name="post-live-publish")
     */
    public function index()
    {
        $user = $this->getUser();

        return $this->render('post/live/publish.html.twig', [
            'token' => '',
            'stream' => uniqid($user->getId().'-'),
        ]);
    }
}