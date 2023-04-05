<?php


namespace Isoros\Routing;

use Isoros\Routing\Request;
use http\Client\Response;

class Router
{
    protected $routes;

    public function __construct()
    {
        $this->routes = [];
    }

    public function addRoute($method, $uri, $handler)
    {
        $route = new Route($method, $uri, $handler);
        $this->routes[] = $route;
    }

    public function match(Request $request)
    {
        foreach ($this->routes as $route) {
            if ($route->getMethod() !== $request->getMethod()) {
                continue;
            }

            $uri = preg_replace('#/+#', '/', $route->getUri());
            $uri = str_replace(['{id}', '{name}'], ['\d+', '[a-zA-Z0-9\-_]+'], $uri);
            $uriPattern = '#^' . $uri . '$#';

            if (preg_match($uriPattern, $request->getUri()->getPath(), $matches)) {
                array_shift($matches);
                return [$route->getHandler(), $matches];
            }
        }

        throw new RouteNotFoundException("Route not found for {$request->getMethod()}: {$request->getUri()->getPath()}");
    }
}