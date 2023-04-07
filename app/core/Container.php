<?php

namespace Isoros\core;

require_once __DIR__ . '/../..//vendor/autoload.php';

use Closure;
//use DI\NotFoundException;
use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    private static Container $instance;
    private $bindings = [];

    public function __construct()
    {
        self::$instance = $this;
    }

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

    public static function getInstance()
    {
        return self::$instance;
    }


    public function has($id): bool
    {
        return isset($this->bindings[$id]);
    }


}