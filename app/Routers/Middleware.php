<?php

namespace Isoros\Middleware;

use Isoros\Routers\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Middleware implements MiddlewareInterface
{
    public function handle(ServerRequestInterface $request, callable $next): ResponseInterface

    {
        // do something before the request is handled by the controller
        if (!App::isLoggedIn()) {
            return redirect('/login');
        }

        // pass the request to the next middleware or controller
        $response = $next($request);

        // do something after the request is handled by the controller
        return $response;
    }
}
