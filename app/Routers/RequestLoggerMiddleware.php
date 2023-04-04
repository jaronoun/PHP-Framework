<?php

namespace Isoros\Routers;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class RequestLoggerMiddleware implements MiddlewareInterface
{
    public function handle(ServerRequestInterface  $request, callable $next): ResponseInterface
    {
        $method = $request->getMethod();
        $uri = $request->getUri();

        // Log de request
        error_log(sprintf("[%s] %s\n", $method, $uri));

        // Laat de volgende middleware in de keten uitvoeren
        $response = $next($request);

        return $response;
    }

}
