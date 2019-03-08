<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\FriendShip;
use App\Entity\User;
use App\Hydrator\HydratorInterface;
use App\Repository\FriendShipRepository;

/**
 * Class RelationshipService
 */
class FriendShipService
{

    /**
     * @var FriendShipRepository
     */
    protected $friendShipRepository;

    /**
     * @var HydratorInterface
     */
    protected $friendShipHydrator;

    /**
     * FriendShipService constructor.
     *
     * @param FriendShipRepository $friendShipRepository
     */
    public function __construct(FriendShipRepository $friendShipRepository, HydratorInterface $hydrator)
    {
        $this->friendShipRepository = $friendShipRepository;
        $this->friendShipHydrator = $hydrator;
    }

    /**
     * @param User   $fromUser
     * @param User   $toUser
     * @param string $friendShipType
     *
     * @return \App\Entity\FriendShip
     */
    public function findFriendShip(User $fromUser, User $toUser, string $friendShipType, ?bool $accepted)
    {
        $params = [
            'friend' => $fromUser,
            'friendWithMe' => $toUser,
            'friendShipType' => $friendShipType,
        ];

        if (null != $accepted) {
            $params['accepted'] = $accepted;
        }

        return $this->friendShipRepository->findOneBy($params);
    }

    public function addFriendShip(User $fromUser, User $toUser, string $friendShipType)
    {
        if ( null == $friendShip = $this->findFriendShip($fromUser, $toUser, $friendShipType, null) ) {
            // TODO: Use strategy instead statements.
            if (FriendShip::TYPE_FOLLOW == $friendShipType) {
                if (null == $this->findFriendShip($fromUser, $toUser, FriendShip::TYPE_FRIEND, true)) {
                    $friendShip = $this->friendShipHydrator->hydrate(
                        [
                            'friend' => $fromUser,
                            'friendWithMe' => $toUser,
                            'friendShipType' => FriendShip::TYPE_FOLLOW,
                            'accept' => true,
                        ]
                    );

                    $this->friendShipRepository->persistAndFlush($friendShip);
                }
            }

            if (FriendShip::TYPE_FRIEND == $friendShipType) {
                $friendShip = $this->friendShipHydrator->hydrate(
                    [
                        'friend' => $fromUser,
                        'friendWithMe' => $toUser,
                        'friendShipType' => FriendShip::TYPE_FRIEND,
                    ]
                );

                $this->friendShipRepository->persistAndFlush($friendShip);
            }
        }
    }

    public function acceptFriendShip(User $fromUser, User $toUser)
    {
        if ( null != $friendShip = $this->findFriendShip($fromUser, $toUser, FriendShip::TYPE_FRIEND, false) ) {
            $friendShip->setAccept(true);
            $inverseFriendShip = $this->friendShipHydrator->hydrate(
                [
                    'friend' => $toUser,
                    'friendWithMe' => $fromUser,
                    'friendShipType' => FriendShip::TYPE_FRIEND,
                    'accept' => true,
                ]
            );


            $this->friendShipRepository->persistAndFlush($friendShip);
            $this->friendShipRepository->persistAndFlush($inverseFriendShip);
        }
    }

    public function removeFriendShip(FriendShip $friendShip)
    {
        $this->friendShipRepository->removeAndFlush($friendShip);
    }
}
