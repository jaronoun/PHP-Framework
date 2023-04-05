<?php

namespace Isoros\Routing;

use Isoros\Routing\Request;
use Isoros\Routing\Response;

class Route
{
    protected $method;
    protected $uri;
    protected $handler;

    public function __construct($method, $uri, $handler)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->handler = $handler;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getHandler()
    {
        return $this->handler;
    }
}