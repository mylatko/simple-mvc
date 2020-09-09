<?php

namespace MVC\controller\api;

use MVC\controller\BaseController;
use MVC\model\News;

class NewsApiController extends BaseController
{
    public function index()
    {
        $news = News::findAll();

        $this->renderJson([
            'news' => $news
        ]);
    }

    public function init()
    {
        $this->setTitle('News api');
    }
}
