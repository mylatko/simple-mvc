<?php

namespace MVC\controller;

use MVC\model\News;

class IndexController extends BaseController
{
    private $view;

    public function index()
    {
        $news = new News();
        $news->id = 1;
        $news->save();

        $this->renderHtml('index/index', [
            'title' => $this->title,
            'news' => $news
        ]);
    }

    protected function init()
    {
        $this->setTitle('MVC main page');
    }
}