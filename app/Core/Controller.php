<?php

namespace Isoros\Core;

class Controller
{
    protected $view;
    protected $db;

    public function __construct()
    {

        $this->db = Database::getInstance();
    }
}
