<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 15/03/19
 * Time: 23:42
 */

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class WebRtcController extends AbstractController
{

    /**
     * @Route("/webrtc/publish", name="webrtc-publish")
     */
    public function index()
    {
        $user = $this->getUser();

        return $this->render('webrtc/index.html.twig', [
            'token' => '',
            'streamId' => uniqid($user->getId().'-'),
        ]);
    }
}