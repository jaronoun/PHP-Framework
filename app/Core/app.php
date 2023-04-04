<?php
namespace Isoros\Core;

use Isoros\Routers\Route;
use Isoros\Routers\ServerRequestFactory;
use Isoros\Routers\RequestInterface;
use Isoros\Routers\ResponseInterface;
use Isoros\Routers\Response;
use Isoros\Routers\MiddlewareInterface;

class App {
    private $routes = [];
    private $middlewares = [];

    public function addRoute(Route $route) {
        $this->routes[] = $route;
    }

    public function addMiddleware(MiddlewareInterface $middleware) {
        $this->middlewares[] = $middleware;
    }

    public function get(string $pattern, $handler) {
        $this->addRoute(new Route($pattern, $handler, ['GET']));
    }

    public function post(string $pattern, $handler) {
        $this->addRoute(new Route($pattern, $handler, ['POST']));
    }

    public function put(string $pattern, $handler) {
        $this->addRoute(new Route($pattern, $handler, ['PUT']));
    }

    public function delete(string $pattern, $handler) {
        $this->addRoute(new Route($pattern, $handler, ['DELETE']));
    }

    public function run(): Response
    {
        $request = ServerRequestFactory::createFromGlobals();

        // apply middlewares to the request
        foreach ($this->middlewares as $middleware) {
            $request = $middleware->handle($request, function(RequestInterface $request) {});
        }

        foreach ($this->routes as $route) {
            if ($route->match($request->getMethod(), $request->getUri()->getPath())) {
                $params = [];

                foreach ($route->getParams() as $name) {
                    $params[$name] = $route->getParamValue($name, $request->getUri()->getPath());
                }

                $handler = $route->getHandler();

                if (is_string($handler)) {
                    [$controllerName, $methodName] = explode('@', $handler);
                    $controller = new $controllerName();

                    return $controller->$methodName($request, $params);
                } else if (is_callable($handler)) {
                    return call_user_func_array($handler, [$request, $params]);
                }
            }
        }

        return new Response('Not Found', 404);
    }
}

