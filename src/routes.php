<?php

return [
    '~^/$~' => [\MVC\controller\IndexController::class, 'index'],
    '~^/news/add$~' => [\MVC\controller\NewsController::class, 'add'],
    '~^/news/(\d+)/delete$~' => [\MVC\controller\NewsController::class, 'delete'],
    '~^/news/(.*)/edit$~' => [\MVC\controller\NewsController::class, 'edit'],
    '~^/news$~' => [\MVC\controller\NewsController::class, 'index'],
    '~^/newsapi$~' => [\MVC\controller\api\NewsApiController::class, 'index'],
    '~^/user/register$~' => [\MVC\controller\UserController::class, 'register'],
    '~^/user/login$~' => [\MVC\controller\UserController::class, 'login'],
    '~^/user/logout$~' => [\MVC\controller\UserController::class, 'logout'],
    '~^/user/(\d+)/activate/(.+)$~' => [\MVC\controller\UserController::class, 'activate'],
    //api
    '~^/newsapi$~' => [\MVC\controller\api\NewsApiController::class, 'index']
];
