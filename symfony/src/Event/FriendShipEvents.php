<?php

declare(strict_types=1);

namespace App\Event;

/**
 * Class FriendShipEvent
 */
class FriendShipEvents
{

    const FRIEND_REQUEST = 'friend_ship.after_friend_request';
    const ACCEPT_FRIEND_REQUEST = 'friend_ship.after_accept_friend_request';
    const FOLLOW_REQUEST = 'friend_ship.after_follow_request';
}
