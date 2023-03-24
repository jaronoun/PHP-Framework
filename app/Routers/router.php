<?php

class Router
{
    protected $routes = [];

    public function addRoute($method, $uri, $handler)
    {
        $this->routes[$method][$uri] = $handler;
    }

    public function dispatch()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $handler = isset($this->routes[$method][$uri]) ? $this->routes[$method][$uri] : null;
        if (!$handler) {
            http_response_code(404);
            echo "Page not found";
            return;
        }
        call_user_func($handler);
    }
}
