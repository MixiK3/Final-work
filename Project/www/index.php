<?php
    
    spl_autoload_register(function (string $className){
        require_once('../src/'.str_replace('\\', '/', $className).'.php');
    });

    $route = $_GET['route'] ?? '';
    $routes = require_once('../src/routes.php');

    $isRouteFound = false;
    foreach($routes as $pattern => $controllerAndAction){
        preg_match($pattern, $route, $matches);
        if (!empty($matches)){
            $isRouteFound = true;
            break;
        }
    }
    if ($isRouteFound){
        unset($matches[0]);
        $controllerName = $controllerAndAction[0];
        $actionName = $controllerAndAction[1];
        $controller = new $controllerName;
        $controller->$actionName(...$matches);
    }else {
        $view = new View\View('../templates');
        $view->renderHtml('errors/error.php', [], 404);
        return;
    }

    
    // var_dump($controllerAndAction);

    // $pattern = '~^hello/(.*)$~';
    // preg_match($pattern, $route, $matches);
    // if (!empty($matches)){
    //     $controller = new Controllers\MainController;
    //     $controller->sayHello($matches[1]);
    // }

    // $pattern = '~^$~';
    // preg_match($pattern, $route, $matches);
    // if (!empty($matches)){
    //     $controller = new Controllers\MainController;
    //     $controller->main();
    // }

    // echo "Страница не найдена";

    // $author = new Models\Users\User("Ivan");
    // $article = new Models\Articles\Article("Title", "Text", $author);

    // var_dump($article);