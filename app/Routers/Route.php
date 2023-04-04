<?php
namespace Isoros\Routers;

class Route
{
    private $uri;
    private $handler;
    private $methods;

    public function __construct(string $uri, $handler, array $methods)
    {
        $this->uri = $uri;
        $this->handler = $handler;
        $this->methods = $methods;
    }

    public function match(string $method, string $path): bool
    {
        return in_array($method, $this->methods) && preg_match($this->uri, $path);
    }

    public function getHandler()
    {
        return $this->handler;
    }
}
