<?php

namespace Isoros\Core;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class EventHandler implements RequestHandlerInterface
{
    protected $router;
    protected $middleware;

    public function __construct($router, $middleware)
    {
        $this->router = $router;
        $this->middleware = $middleware;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $route = $this->router->findRoute($request->getMethod(), $request->getUri()->getPath());
            if (!$route) {
                throw new Exception("Route not found.");
            }

            // Check if middleware needs to be executed before controller
            if ($route->hasMiddleware()) {
                $middlewareClasses = $route->getMiddleware();
                foreach ($middlewareClasses as $middlewareClass) {
                    $middleware = new $middlewareClass();
                    if (!$middleware instanceof MiddlewareInterface) {
                        throw new Exception("Middleware must be an instance of MiddlewareInterface.");
                    }
                    $request = $middleware->process($request, $this);
                }
            }

            $controllerName = $route->getController();
            $actionName = $route->getAction();

            $controllerClass = "\\Isoros\\Controllers\\api\\" . $controllerName . "Controller";
            if (!class_exists($controllerClass)) {
                $controllerClass = "\\Isoros\\Controllers\\web\\" . $controllerName . "Controller";
                if (!class_exists($controllerClass)) {
                    throw new Exception("Controller not found.");
                }
            }

            $controller = new $controllerClass();

            if (!method_exists($controller, $actionName)) {
                throw new Exception("Action not found.");
            }

            $response = $controller->$actionName($request);

            return $response;
        } catch (Exception $e) {
            // Handle exception and return response
            return response()->error($e->getMessage());
        }
    }
}

