<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Notification;
use App\Entity\User;
use App\Repository\NotificationRepository;

/**
 * Class NotificationService
 */
class NotificationService
{

    /**
     * @var NotificationRepository
     */
    protected $repository;

    /**
     * NotificationService constructor.
     *
     * @param NotificationRepository $repository
     */
    public function __construct(NotificationRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Send notification by registering it to database.
     *
     * @param Notification $notification
     */
    public function sendNotification(Notification $notification)
    {
        $this->repository->persistAndFlush($notification);
    }

    /**
     * @param User $user
     *
     * @return mixed
     */
    public function getUnreadNotificationByUser(User $user)
    {
        return $this->repository->findUnreadNotificationByUser($user);
    }

}
