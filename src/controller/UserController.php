<?php

namespace MVC\controller;

use MVC\exception\InvalidArgumentException;
use MVC\model\User;
use MVC\services\UserAuthService;
use MVC\services\EmailSender;
use MVC\services\UsersActivationService;

class UserController extends BaseController
{
    /**
     * Registration
     */
    public function register()
    {
        if (!empty($_POST)) {
            try {
                $user = User::register($_POST);
            } catch (InvalidArgumentException $e) {
                $this->renderHtml('user/register', [
                    'error' => $e->getMessage()
                ]);
                return;
            }

            if ($user instanceof User) {
                $code = UsersActivationService::createActivationCode($user);
                EmailSender::send($user, 'Activation', 'userActivation',
                    [
                        'userId' => $user->getId(),
                        'code' => $code
                    ]);

                $this->renderHtml('user/successRegister');
                return;
            }
        }

        $this->renderHtml('user/register', []);
    }

    /**
     *
     */
    public function init()
    {
        $this->setTitle('User page');
    }

    /**
     * Activation
     * @param int $userId
     * @param string $code
     */
    public function activate(int $userId, string $code)
    {
        $user = User::getById($userId);

        try {
            if (!$user)
                throw new \Exception('User not registered');
            if ($user->getIsConfirmed())
                throw new \Exception('User already confirmed');

            $result = UsersActivationService::checkActivationCode($user, $code);
            if ($result) {
                $user->activate();
                UsersActivationService::clearActivationCode($user, $code);
                echo "Successfully activated";
            } else {
                throw new \Exception('Activation code not found');
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Login
     */
    public function login()
    {
        if (!empty($_POST)) {
            try {
                $user = User::login($_POST);
                UserAuthService::createToken($user);
                header('Location: /');
                exit();
            } catch (InvalidArgumentException $e) {
                $this->renderHtml('user/login', [
                    'error' => $e->getMessage()
                ]);
                return;
            }
        }
        $this->renderHtml('user/login');
    }

    /**
     * Logout
     */
    public function logout()
    {
        if ($this->getVar('user')) {
            UserAuthService::removeToken($this->getVar('user'));
            $this->unsetVar('user');
            header('Location: /');
            exit();
        } else {
            echo "User not logged";
        }
    }
}
