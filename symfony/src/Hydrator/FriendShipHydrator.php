<?php

declare(strict_types=1);

namespace App\Hydrator;

use App\Entity\FriendShip;

/**
 * Class FriendShipHydrator
 */
class FriendShipHydrator implements HydratorInterface
{

    /**
     * {@inheritdoc}
     */
    public function hydrate(array $properties): FriendShip
    {
        $friendShip = new FriendShip();

        foreach ($properties as $key => $property) {
            $accessor = 'set'.ucfirst($key);
            $friendShip->{$accessor}($property);
        }

        return $friendShip;
    }
}
