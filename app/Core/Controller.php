<?php

namespace Isoros\Core;

use Isoros\Core\App;

class Controller
{
    protected $view;
    protected $db;

    public function __construct()
    {
        $this->db = App::getInstance()->getDbConnection();
    }

}
