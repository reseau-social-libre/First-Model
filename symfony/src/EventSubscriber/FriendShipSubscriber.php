<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Event\FriendShipEvent;
use App\Event\FriendShipEvents;
use App\Manager\NotificationManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class FriendShipSubscriber
 */
class FriendShipSubscriber implements EventSubscriberInterface
{

    /**
     * @var NotificationManager
     */
    protected $notificationManager;

    /**
     * FriendShipSubscriber constructor.
     *
     * @param NotificationManager $notificationManager
     */
    public function __construct(NotificationManager $notificationManager)
    {
        $this->notificationManager = $notificationManager;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            FriendShipEvents::FRIEND_REQUEST => 'onFriendRequest',
            FriendShipEvents::ACCEPT_FRIEND_REQUEST => 'onAcceptFriendRequest',
            FriendShipEvents::FOLLOW_REQUEST => 'onFollowRequest',
        ];
    }

    /**
     * @param FriendShipEvent $event
     */
    public function onAcceptFriendRequest(FriendShipEvent $event)
    {
        $this->notificationManager->createAcceptFriendRequestNotification($event);
    }

    /**
     * @param FriendShipEvent $event
     */
    public function onFollowRequest(FriendShipEvent $event)
    {
        $this->notificationManager->createFollowRequestNotification($event);
    }

    /**
     * @param FriendShipEvent $event
     */
    public function onFriendRequest(FriendShipEvent $event)
    {
        $this->notificationManager->createFriendRequestNotification($event);
    }
}
