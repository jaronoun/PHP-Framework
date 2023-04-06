<?php

namespace Isoros\Routers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Router implements RequestHandlerInterface
{
    protected $routes = [];

    public function addRoute($method, $uri, $handler)
    {

        $this->routes[$method][$uri] = $handler;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $method = $_SERVER['REQUEST_METHOD'];

        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';

        $handler = $this->routes[$method][$uri] ?? null;

        if (!$handler) {
            http_response_code(404);
            echo "Page not found";
            return new Response();
        }
        // Instead of calling the handler directly, we call the loadView method
        return $this->loadView($handler);
    }

    // Method to load the appropriate view based on the handler
    protected function loadView($handler)
    {

        $parts = explode('@', $handler);
        $controllerName = $parts[0];
        $methodName = $parts[1];
        $controllerPath = realpath(__DIR__ . '/../../app/controllers/web/' . $controllerName . '.php');



        if (!file_exists($controllerPath)) {
            http_response_code(500);
            echo "Controller not found";
            return;
        }

        // Met de juiste namespace
        $controllerName = "Isoros\\controllers\\web\\" . $parts[0];
        // create the controller instance
        $controller = new $controllerName();

        // call the method on the controller instance
        $controller->$methodName();

        return new Response();

    }
}
