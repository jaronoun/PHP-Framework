<?php
namespace Isoros\Routers;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Isoros\Routers\MiddlewareNotFoundException;

class MiddlewareStack implements RequestHandlerInterface
{
    private $middlewares = [];

    public function addMiddleware(MiddlewareInterface $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if (!$this->middlewares) {
            throw new MiddlewareNotFoundException();
        }

        $middleware = array_shift($this->middlewares);

        return $middleware->process($request, $this);
    }
}
