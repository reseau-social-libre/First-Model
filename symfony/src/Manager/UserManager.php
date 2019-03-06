<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\User;
use App\Service\UserService;

/**
 * Class UserManager
 */
class UserManager
{

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * UserManager constructor.
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param string $username
     * @param string $sessionUsername
     *
     * @return bool
     */
    public function checkUserByUsername(string $username, string $sessionUsername)
    {
        return $username == $sessionUsername;
    }

    /**
     * Get user by username.
     *
     * @param string $username
     *
     * @return User|null
     */
    public function getUserByUsername(string $username)
    {
        return $this->userService->getUserBy([
            'username' => $username,
        ]);
    }


}
