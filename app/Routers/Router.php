<?php

namespace Isoros\Routers;

use Isoros\Routers\MiddlewareNotFoundException;
use Isoros\Routers\RouteNotFoundException;
use Psr\Http\Message\ServerRequestInterface;


class Router
{
    private $routeCollection;

    public function __construct(RouteCollection $routeCollection)
    {
        $this->routeCollection = $routeCollection;
    }

    public function addRoute(Route $route)
    {
        $this->routeCollection->addRoute($route);
    }

    public function match(ServerRequestInterface $request)
    {
        $route = $this->routeCollection->match($request->getMethod(), $request->getUri()->getPath());
        if (!$route) {
            throw new \Isoros\Routers\RouteNotFoundException();
        }
        return $route;
    }

    public function runMiddleware(ServerRequestInterface $request, MiddlewareStack $middlewareStack)
    {
        try {
            return $middlewareStack->handle($request);
        } catch (MiddlewareNotFoundException $e) {
            throw new MiddlewareNotFoundException();
        }
    }
}

