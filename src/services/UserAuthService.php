<?php

namespace MVC\services;

use MVC\model\User;

class UserAuthService
{
    /**
     * Set token to cookie
     * @param User $user
     */
    public static function createToken(\MVC\model\User $user): void
    {
        $token = $user->getId() . ":" . $user->getAuthToken();
        setcookie('token', $token, 0, '/', '', false, true);
    }

    /**
     * @return User|null
     */
    public static function getUserByToken(): ?User
    {
        $token = $_COOKIE['token'] ?? '';

        if (empty($token)) {
            return null;
        }

        [$userId, $authToken] = explode(':', $token, 2);

        $user = User::getById((int) $userId);
        if (!$user) {
            return null;
        }

        if ($user->getAuthToken() !== $authToken) {
            return null;
        }

        return $user;
    }

    public static function removeToken(\MVC\model\User $user): void
    {
        $token = $user->getId() . ":" . $user->getAuthToken();
        setcookie('token', $token, time() - 3600, '/', '');
    }
}
