<?php

namespace Isoros\core;

class View
{
    protected $view;
    protected $data = [];

    public function __construct($view, $data = [])
    {
        $this->view = $view;
        $this->data = $data;
    }

    public function render()
    {
        extract($this->data);
        require "../app/views/{$this->view}.php";
    }
}

