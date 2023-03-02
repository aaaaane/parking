<?php

use DevCoder\Exception\MethodNotAllowed;
use DevCoder\Exception\RouteNotFound;
use DevCoder\Router;

try {
    require "../vendor/autoload.php";
    include_once "../routes/routes.php";

    $router = new Router($routes, 'http://127.0.0.1:8080');

    $route = $router->matchFromPath($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
    $handler = $route->getHandler();
    // $attributes = ['id' => 2]
    $attributes = $route->getAttributes();

    $controllerName = $handler[0];
    $methodName = $handler[1] ?? null;

    $controller = new $controllerName();
    if (!is_callable($controller)) {
        $controller = [$controller, $methodName];
    }

    $response = $controller(...array_values($attributes));

    http_response_code($response["status"]);

    echo $response["message"];

} catch (MethodNotAllowed $exception) {
    header("HTTP/1.0 405 Method Not Allowed");
    exit();
} catch (RouteNotFound $exception) {
    header("HTTP/1.0 404 Not Found");
    exit();
}
