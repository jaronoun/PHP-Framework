<?php

namespace Isoros\Routers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;

class Router
{
    private $routes = [];
    private $middleware = [];

    public function addRoute($method, $path, $handler)
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }

    public function registerMiddleware(MiddlewareInterface $middleware): void
    {
        $this->middleware[] = $middleware;
    }

    public function handle(Request $request): Response
    {
        foreach ($this->routes as $route) {
            if ($route['method'] == $request->getMethod()
                && preg_match('#^' . $route['path'] . '$#', $request->getUri()->getPath(), $matches)) {
                array_shift($matches);
                $params = array_values($matches);
                return $route['handler']($request, ...$params);
            }
        }
        throw new \Exception("No matching route found for " . $request->getMethod() . " " . $request->getUri()->getPath(), 404);
    }
}