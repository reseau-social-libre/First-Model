<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Manager\NotificationManager;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class NotificationController
 */
class NotificationController extends AbstractFOSRestController
{

    /**
     * @var NotificationManager
     */
    protected $notificationManager;

    /**
     * NotificationController constructor.
     *
     * @param NotificationManager $notificationManager
     */
    public function __construct(NotificationManager $notificationManager)
    {
        $this->notificationManager = $notificationManager;
    }

    /**
     * @Rest\View()
     * @Rest\Post("/notification/clear")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function markAsReadAction(Request $request)
    {
        $repo = $this->getDoctrine()->getRepository(User::class);
        $user = $repo->find($request->request->get('user'));

        if (null === $user) {
            return new Response(Response::HTTP_NOT_FOUND);
        }

        try {
            if ($this->notificationManager->clearNotification($user)) {
                return new Response(Response::HTTP_OK);
            }

            return new Response(Response::HTTP_INTERNAL_SERVER_ERROR);

        } catch (\Exception $e) {
            return new Response(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
