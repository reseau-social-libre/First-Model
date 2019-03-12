<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Notification;
use App\Entity\User;
use App\Event\FriendShipEvent;
use App\Service\NotificationService;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class NotificationManager
 */
class NotificationManager
{

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var NotificationService
     */
    protected $notificationService;

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * NotificationManager constructor.
     *
     * @param NotificationService $notificationService
     * @param RouterInterface     $router
     * @param TranslatorInterface $translator
     */
    public function __construct(NotificationService $notificationService, RouterInterface $router, TranslatorInterface $translator)
    {
        $this->notificationService = $notificationService;
        $this->router = $router;
        $this->translator = $translator;
    }

    /**
     * Create a notification for friend request event.
     *
     * @param FriendShipEvent $event
     */
    public function createFriendRequestNotification(FriendShipEvent $event)
    {
        $user = $event->getUser();
        $friend = $event->getFriend();

        $notification = new Notification();
        $notification->setUser($friend);
        $notification->setUserSender($user);
        $notification->setLink($this->router->generate('profile', ['username' => $user->getUsername()]));
        $notification->setContent($this->translator->trans('notification.sent_friend_request'));

        $this->notificationService->sendNotification($notification);
    }

    /**
     * @param User $user
     *
     * @return mixed
     */
    public function getUnreadNotificationByUser(User $user)
    {
        return $this->notificationService->getUnreadNotificationByUser($user);
    }

    /**
     * @param FriendShipEvent $event
     */
    public function createAcceptFriendRequestNotification(FriendShipEvent $event)
    {
        $user = $event->getUser();
        $friend = $event->getFriend();

        $notification = new Notification();
        $notification->setUser($user);
        $notification->setUserSender($friend);
        $notification->setLink($this->router->generate('profile', ['username' => $friend->getUsername()]));
        $notification->setContent($this->translator->trans('notification.accept_friend_request'));

        $this->notificationService->sendNotification($notification);
    }

    /**
     * @param FriendShipEvent $event
     */
    public function createFollowRequestNotification(FriendShipEvent $event)
    {
        $user = $event->getUser();
        $friend = $event->getFriend();

        $notification = new Notification();
        $notification->setUser($friend);
        $notification->setUserSender($user);
        $notification->setLink($this->router->generate('profile', ['username' => $user->getUsername()]));
        $notification->setContent($this->translator->trans('notification.follow_request'));

        $this->notificationService->sendNotification($notification);
    }

    /**
     * Mark all notification as seen.
     *
     * @param \App\Entity\User $user
     *
     * @return bool
     */
    public function clearNotification(User $user): bool
    {
        return $this->notificationService->markAllAsSeen($user);
    }
}
