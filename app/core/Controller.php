<?php

namespace Isoros\core;

use Psr\Container\ContainerInterface;

class Controller
{
    protected $container;
    protected $db;

    public function __construct()
    {
        $this->container = Container::getInstance();
        //$this->db = $container->get(Database::class);
    }

    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

}
