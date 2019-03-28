<?php

declare(strict_types=1);

namespace App\Controller\Front;

use App\Manager\NotificationManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class NotificationController
 */
class NotificationController extends AbstractController
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
     * @return Response
     */
    public function notificationMenuAction()
    {
        $user = $this->getUser();

        $notifications = $this->notificationManager->getUnreadNotificationByUser($user);

        return $this->render('menu/notification.html.twig', [
            'notifications' => $notifications,
            'user_id' => $user->getId(),
        ]);
    }
}
