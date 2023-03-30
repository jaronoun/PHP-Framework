<?php

namespace Isoros\Core;

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

        //$data1 = $this->data->fetchAll(\PDO::FETCH_ASSOC);
        //var_dump($data1);

        require "../app/Views/{$this->view}.php";
    }
}

