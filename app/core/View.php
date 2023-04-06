<?php

namespace Isoros\core;

class View
{
    protected $view;
    protected $data = [];

    public function __construct()
    {

    }

    public function render($view)
    {
        //extract($this->data);
        require "../app/views/{$view}.php";
    }
}

