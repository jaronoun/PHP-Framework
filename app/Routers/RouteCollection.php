<?php
namespace Isoros\Routers;

class RouteCollection
{
    private $routes;

    public function __construct()
    {
        $this->routes = [];
    }

    public function addRoute(Route $route)
    {
        $this->routes[] = $route;
    }

    public function match(string $method, string $path)
    {
        foreach ($this->routes as $route) {
            if ($route->match($method, $path)) {
                return $route;
            }
        }
        return null;
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }
}