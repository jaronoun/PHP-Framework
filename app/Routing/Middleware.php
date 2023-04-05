<?php

namespace Isoros\Routing;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;

class Middleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, \Psr\Http\Server\RequestHandlerInterface $handler): ResponseInterface
    {
        // Voer middleware logica uit
        // ...

        // Roep de volgende handler aan en ontvang de reactie
        $response = $handler->handle($request);

        // Voer eventuele logica uit na het aanroepen van de handler
        // ...

        return $response;
    }
}