<?php

namespace MVC\services;

use MVC\services\Db;
use MVC\services\Db;

class UsersActivationService
{
    protected static $tableName = 'users_activation_codes';

    public static function createActivationCode(\MVC\model\User $user): string
    {
        $code = bin2hex(random_bytes(16));

        $sql = "INSERT INTO `" . self::$tableName . "` (user_id, code) VALUES(:user_id, :code);";

        $db = Db::getInstance();
        $db->query($sql, [
            ':user_id' => $user->getId(),
            ':code' => $code
        ]);

        return $code;
    }

    public static function checkActivationCode(\MVC\model\User $user, string $code): bool
    {
        $db = Db::getInstance();
        $sql = "SELECT * FROM `" . self::$tableName . "` WHERE user_id = :user_id AND code = :code;";
        $result = $db->query($sql, [
            ':user_id' => $user->getId(),
            ':code' => $code
        ]);

        return !empty($result);
    }

    public static function clearActivationCode(\MVC\model\User $user, string $code)
    {
        $db = Db::getInstance();
        $sql = "DELETE FROM `" . self::$tableName . "` WHERE user_id = :user_id AND code = :code;";
        $db->query($sql, [
            ':user_id' => $user->getId(),
            ':code' => $code
        ]);
    }
}
