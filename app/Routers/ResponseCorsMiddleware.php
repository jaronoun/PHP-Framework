<?php

namespace Isoros\Routers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;


class ResponseCorsMiddleware implements MiddlewareInterface
{
    public function handle(RequestInterface $request, callable $next): ResponseInterface
    {
        // Invoke the next middleware in the stack to get the response
        $response = $next($request);

        // Add the CORS headers to the response
        $response = $response->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');

        return $response;
    }
}
