<?php

namespace Isoros\routing;

use Isoros\core\Container;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Router implements RequestHandlerInterface
{
    protected $routes = [];
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function addRoute($method, $uri, $handler)
    {
        $pattern = $this->convertUriToPattern($uri);
        $this->routes[$method][$pattern] = $handler;
    }

    protected function convertUriToPattern($uri)
    {
        // Vervang de ID-placeholder door een reguliere expressie-patroon
        $pattern = preg_replace('/\{(\w+)\}/', '(?<$1>[^/]+)', $uri);

        // Voeg ankertekens toe om de overeenkomst te beperken tot het volledige pad
        $pattern = '/^' . str_replace('/', '\/', $pattern) . '$/';

        return $pattern;
    }

    protected function extractIdFromUri($uri, $pattern)
    {
        preg_match($pattern, $uri, $matches);
        $id = $matches['id'] ?? null;

        return $id;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';

        $handler = $this->matchRoute($method, $uri);

        if (!$handler) {
            http_response_code(404);
            echo "Page not found";
            return new Response();
        }

        // Haal het reguliere expressiepatroon op dat overeenkomt met de route
        $pattern = array_keys($this->routes[$method], $handler)[0];

        // Extract the ID from the URI using the pattern
        $id = $this->extractIdFromUri($uri, $pattern);

        // Instead of calling the handler directly, we call the loadView method
        return $this->loadView($handler, $id);
    }

    protected function matchRoute($method, $uri)
    {
        foreach ($this->routes[$method] as $pattern => $handler) {
            if (preg_match($pattern, $uri)) {
                return $handler;
            }
        }

        return null;
    }

    // Method to load the appropriate view based on the handler


    protected function loadView($handler, $id)
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
        $controller = $this->container->make($controllerName);

        // call the method on the controller instance
        if(!$id==null) {
            $controller->$methodName($id);
        } else {
            $controller->$methodName();
        }
        return new Response();
    }
}
