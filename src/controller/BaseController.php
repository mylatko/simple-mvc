<?php

namespace MVC\controller;

use MVC\services\Db;

abstract class BaseController
{
    /** @var string */
    private $templatesPath;

    /** @var string */
    protected $title;

    /** @var Db object */
    protected $db;

    public function __construct()
    {
        $this->templatesPath = __DIR__ . '/../view/';

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

        ob_start();
        include $this->templatesPath . "/" . $templateName . '.phtml';
        $buffer = ob_get_contents();
        ob_end_clean();

        echo $buffer;
    }

    abstract protected function init();
}
