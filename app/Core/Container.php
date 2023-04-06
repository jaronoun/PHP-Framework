<?php

namespace Isoros\Core;

require_once __DIR__ . '/../..//vendor/autoload.php';

use Closure;
//use DI\NotFoundException;
use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    private $bindings = [];

    public function set($id, $concrete)
    {
        $this->bindings[$id] = $concrete;
    }

    public function get($id)
    {
        if (!$this->has($id)) {
            //throw new NotFoundException();
        }

        $concrete = $this->bindings[$id];

        if ($concrete instanceof Closure) {
            return $concrete($this);
        }

        return new $concrete;
    }


    public function has($id): bool
    {
        return isset($this->bindings[$id]);
    }


}