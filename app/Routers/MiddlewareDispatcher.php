<?php

namespace Isoros\Routers;

use Isoros\core\Container;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class MiddlewareDispatcher implements MiddlewareInterface
{
    protected $container;
    protected $middlewares = [];

    public function __construct(ContainerInterface $container, array $middlewares)
    {
        $this->container = $container;
        $this->middlewares = $middlewares;
    }

    public function process(RequestInterface|ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // Bouw de middlewareketen op
        $current = new Middleware();
        for ($i = count($this->middlewares) - 1; $i >= 0; $i--) {
            $middleware = $this->container->get($this->middlewares[$i]);
            $middleware->setNext($current);
            $current = $middleware;
        }

        // Verwerk de request
        return $current->process($request, $handler);
    }

    public static function fromContainer(Container $container): MiddlewareDispatcher
    {

        // Voeg de benodigde bindings toe aan de Container
        // $container->set('','');

        // Geef de middleware array door als een parameter
        //$middlewares = $container->get('')[''];
        $middlewares = [];

        // Maak een nieuwe MiddlewareDispatcher en geef deze terug
        return new self($container, $middlewares);
    }
}

