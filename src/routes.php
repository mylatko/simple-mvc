<?php

return [
    '~^/$~' => [\MVC\controller\IndexController::class, 'index'],
    '~^/news/add$~' => [\MVC\controller\NewsController::class, 'add'],
    '~^/news/(\d+)/delete$~' => [\MVC\controller\NewsController::class, 'delete'],
    '~^/news/(.*)$~' => [\MVC\controller\NewsController::class, 'index'],
];
