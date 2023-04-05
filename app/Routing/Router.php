<?php


namespace Isoros\Routing;

use Request;
use Response;

class Router
{
    protected $routes = [];

    public function addRoute($method, $path, $handler)
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }

    public function dispatch(Request $request): Response
    {
        $method = $request->getMethod();
        $path = $request->getUri()->getPath();

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            $pattern = '~^' . preg_replace('/{([^}]*)}/', '(?P<$1>[^/]+)', $route['path']) . '$~';

            if (preg_match($pattern, $path, $matches)) {
                $params = [];
                foreach ($matches as $key => $value) {
                    if (!is_int($key)) {
                        $params[$key] = $value;
                    }
                }
                array_unshift($params, $request);
                return call_user_func_array($route['handler'], $params);
            }
        }

        return new Response(404);
    }
}