<?php

try {
    require __DIR__ . '/../vendor/autoload.php';

    $route = $_SERVER['REQUEST_URI'];
    $routes = require __DIR__ . '/../src/routes.php';

    $isRouteFound = false;

    foreach ($routes as $pattern => $controllerAction) {
        preg_match($pattern, $route, $matches);
        if ($matches) {
//        var_dump($pattern);
            $isRouteFound = true;
            break;
        }
    }

    if (!$isRouteFound) {
        throw new \MVC\exception\NotfoundException('Page not found');
        return;
    }

    $controllerName = $controllerAction[0];
    $actionName = $controllerAction[1];

    if(!empty($matches)) {
        $controller = new $controllerName();
        $controller->$actionName($matches[1]);
        return;
    }

    $controller = new $controllerName();
    $controller->$actionName();
} catch (\MVC\Exception\DbException $e) {
    $view = new MVC\controller\ErrorController();
    $view->renderHtml('errors/500', [
        'error' => $e->getMessage()
    ], 500);
} catch (MVC\exception\NotfoundException $e) {
    $view = new MVC\controller\ErrorController();
    $view->renderHtml('errors/404', [
        'error' => $e->getMessage()
    ], 404);
}
