<?php

namespace MVC\controller;

use MVC\services\Db;
use MVC\services\UserAuthService;

abstract class BaseController
{
    /** @var string */
    private $templatesPath;

    /** @var string */
    protected $title;

    /** @var Db object */
    protected $db;

    /**
     * @var array
     */
    private $viewVars = [];

    /**
     * @var
     */
    private $user;

    public function __construct()
    {
        $this->templatesPath = __DIR__ . '/../view/';

        $this->user = UserAuthService::getUserByToken();
        $this->setVar('user', $this->user);

        $this->init();
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    public function renderHtml(string $templateName, array $vars = [], $code = 200)
    {
        http_response_code($code);

        extract($vars);
        extract($this->viewVars);

        ob_start();
        include $this->templatesPath . "/" . $templateName . '.phtml';
        $buffer = ob_get_contents();
        ob_end_clean();

        echo $buffer;
    }

    /**
     * @param $data
     * @param int $code
     */
    public function renderJson($data, $code = 200)
    {
        header('Content-type: application/json; charset=utf-8');
        http_response_code($code);
        echo json_encode($data);
    }

    public function getInputData()
    {
        return json_decode(
            file_get_contents('php://input'),
            true
        );
    }

    /**
     * @param string $name
     * @param $value
     */
    public function setVar(string $name, $value): void
    {
        $this->viewVars[$name] = $value;
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function getVar(string $name)
    {
        if (isset($this->viewVars[$name]) && !empty($this->viewVars[$name]))
            return $this->viewVars[$name];

        return null;
    }

    /**
     * @param $name
     * @return null
     */
    public function unsetVar($name)
    {
        if (isset($this->viewVars[$name]))
            unset($this->viewVars[$name]);

        return null;
    }

    abstract protected function init();
}
