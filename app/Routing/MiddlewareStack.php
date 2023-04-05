<?php

namespace Isoros\Routing;

class MiddlewareStack
{
    private $middlewares = [];

    public function add(MiddlewareInterface $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    public function handle(Request $request): Response
    {
        $next = function (Request $request) {
            // End of the stack reached, return a default response
            return new Response();
        };

        // Iterate over middlewares in reverse order and compose the $next function
        for ($i = count($this->middlewares) - 1; $i >= 0; $i--) {
            $middleware = $this->middlewares[$i];
            $next = function (Request $request) use ($middleware, $next) {
                return $middleware->handle($request, $next);
            };
        }

        // Call the composed $next function with the initial request
        return $next($request);
    }
}