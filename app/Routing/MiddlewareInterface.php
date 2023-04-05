<?php

namespace Isoros\Routing;

interface MiddlewareInterface
{
    public function handle(Request $request, Closure $next): Response;
}