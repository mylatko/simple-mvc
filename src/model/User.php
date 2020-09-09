<?php

namespace MVC\model;

use MVC\exception\InvalidArgumentException;
use MVC\services\Db;

class User extends ActiveRecordEntity
{
    /**
     * @var string
     */
    protected $nickname;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var int
     */
    protected $is_confirmed;

    /**
     * @var enum('admin', 'user')
     */
    protected $role;

    /**
     * @var string
     */
    protected $password_hash;

    /**
     * @var string
     */
    protected $auth_token;

    /**
     * @var string
     */
    protected $date;

    /**
     * @param array $userData
     * @return User
     * @throws InvalidArgumentException
     */
    public static function register(array $userData): User
    {
        if (empty($userData['nickname'])) {
            throw new InvalidArgumentException('Empty nickname');
        }

        if (preg_match("/^[a-zA-Z0-9]$/", $userData['nickname'])) {
            throw new InvalidArgumentException('Nickname');
        }

        if (static::findOneByColumn('nickname', $userData['nickname']) !== null) {
            throw new InvalidArgumentException('User with this nickname already exists');
        }

        if (empty($userData['email'])) {
            throw new InvalidArgumentException('Empty email');
        }

        if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Not valid email');
        }

        if (static::findOneByColumn('email', $userData['email']) !== null) {
            throw new InvalidArgumentException('User with this email already exists');
        }

        if (empty($userData['password'])) {
            throw new InvalidArgumentException('Empty password');
        }

        if (mb_strlen($userData['password']) < 8) {
            throw new InvalidArgumentException('Password should be more than 8 symbols');
        }

        $user = new User();
        $user->nickname = $userData['nickname'];
        $user->email = $userData['email'];
        $user->password_hash = password_hash($userData['password'], PASSWORD_DEFAULT);
        $user->is_confirmed = 0;
        $user->role = 'user';
        $user->auth_token = sha1(random_bytes(100)) . sha1(random_bytes(100));
        $user->save();

        return $user;
    }

    /**
     * @param array $userData
     */
    public static function login(array $userData)
    {
        if (empty($userData['email'])) {
            throw new InvalidArgumentException('Empty email');
        }

        if (empty($userData['password'])) {
            throw new InvalidArgumentException('Empty password');
        }

        $user = static::findOneByColumn('email', $userData['email']);
        if ($user === null) {
            throw new InvalidArgumentException('User not found');
        }

        if (!password_verify($userData['password'], $user->getPasswordHash())) {
            throw new InvalidArgumentException('Password not valid');
        }

        if (!$user->getIsConfirmed()) {
            throw new InvalidArgumentException('User not confirmed');
        }

        $user->refreshAuthToken();
        $user->save();

        return $user;
    }

    /**
     * @return string
     */
    protected static function getTableName(): string
    {
        return 'users';
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return int
     */
    public function getIsConfirmed()
    {
        return $this->is_confirmed;
    }

    /**
     * @return string
     */
    public function getPasswordHash()
    {
        return $this->password_hash;
    }

    /**
     * @return string
     */
    public function getAuthToken()
    {
        return $this->auth_token;
    }

    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * Activate user
     */
    public function activate()
    {
        $this->is_confirmed = 1;
        $this->save();
    }

    private function refreshAuthToken()
    {
        $this->auth_token = sha1(random_bytes(100)) . sha1(random_bytes(100));
    }
}
