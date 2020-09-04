<?php

namespace MVC\controller;

use MVC\exception\NotfoundException;
use MVC\model\News;

class NewsController extends BaseController
{
    public function index()
    {
        $news = News::findAll();

        $this->renderHtml('news/index', [
            'news' => $news
        ]);
    }

    public function edit()
    {
        
    }

    public function add()
    {
//        echo "<pre>";
        $news = new News();
        $news->setTitle("test");
        $news->setSlug("test13");
        $news->setStatus(1);
        $news->save();

//        var_dump($news->getId());
//        $news = News::getById(13);

        $news->setSlug("Another test13");
        $news->save();

    }

    public function delete(int $newsId)
    {
        $newsById = News::getById($newsId);

        if(!$newsById)
            throw new NotfoundException("News not found");
        else {
            $newsById->delete();
            echo "Delete successfully";
        }
    }

    public function init()
    {
        $this->setTitle('News page');
    }
}