<?php

namespace Isoros\routing;

use Isoros\core\Container;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use ReflectionException;

class Router implements RequestHandlerInterface
{
    protected array $routes = [];
    protected ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function addRoute($method, $uri, $handler): void
    {
        $pattern = $this->convertUriToPattern($uri);
        $this->routes[$method][$pattern] = $handler;
    }

    protected function convertUriToPattern($uri): string
    {
        // Vervang de ID-placeholder door een reguliere expressie-patroon
        $pattern = preg_replace('/\{(\w+)\}/', '(?<$1>[^/]+)', $uri);

        // Voeg ankertekens toe om de overeenkomst te beperken tot het volledige pad
        $pattern = '/^' . str_replace('/', '\/', $pattern) . '$/';

        return $pattern;
    }

    protected function extractVariablesFromUri($uri, $pattern): array
    {
        preg_match($pattern, $uri, $matches);

        // Remove the first element, which contains the full match
        array_shift($matches);

        // Filter out numeric keys to keep only named variables
        $variables = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

        return $variables;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';

        $handler = $this->matchRoute($method, $uri);

        if (!$handler) {
            return new Response(404, [], 'Page not found');
        }

        // Haal het reguliere expressiepatroon op dat overeenkomt met de route
        $pattern = array_keys($this->routes[$method], $handler)[0];

        // Extract variables from the URI using the pattern
        $variables = $this->extractVariablesFromUri($uri, $pattern);

        // Instead of calling the handler directly, we call the loadView method
        return $this->loadView($handler, $variables);
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


    /**
     * @throws ReflectionException
     */
    protected function loadView($handler, $variables): Response
    {

        $parts = explode('@', $handler);
        $controllerName = $parts[0];
        $methodName = $parts[1];
        $controllerPath = realpath(__DIR__ . '/../../app/controllers/web/' . $controllerName . '.php');

        if (!file_exists($controllerPath)) {
            return new Response(500, [], 'Controller not found');
        }

        // Met de juiste namespace
        $controllerName = "Isoros\\controllers\\web\\" . $parts[0];
        // create the controller instance
        $controller = $this->container->make($controllerName);

        // Call the method on the controller instance, passing the extracted variables
        $controller->$methodName(...$variables);

        return new Response();
    }
}
