<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\FriendShip;
use App\Entity\User;
use App\Service\FriendShipService;

/**
 * Class FriendShipManager
 */
class FriendShipManager
{

    /**
     * @var FriendShipService
     */
    protected $friendShipService;

    /**
     * RelationshipManager constructor.
     *
     * @param FriendShipService $friendShipService
     */
    public function __construct(FriendShipService $friendShipService)
    {
        $this->friendShipService = $friendShipService;
    }

    public function addFriendShip(User $fromUser, User $toUser, $friendShipType)
    {

        $this->friendShipService->addFriendShip($fromUser, $toUser, $friendShipType);
    }

    /**
     * @param User      $fromUser
     * @param User      $toUser
     * @param string    $friendShipType
     *
     * @param bool|null $accepted
     *
     * @return \App\Entity\FriendShip
     */
    public function getFriendShip(User $fromUser, User $toUser, string $friendShipType, ?bool $accepted)
    {
        return $this->friendShipService->findFriendShip($fromUser, $toUser, $friendShipType, $accepted);
    }

    public function acceptFriendShip($user, $toUser)
    {
        $this->friendShipService->acceptFriendShip($user, $toUser);
    }

}
