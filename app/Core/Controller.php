<?php

namespace Isoros\core;

use Isoros\core\App;
use Psr\Container\ContainerInterface;

class Controller
{
    protected ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

}
