<?php

namespace App\Views;

class View
{
    protected $data;

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function render($template)
    {
        $path = __DIR__ . '/../views/' . $template . '.php';

        if (!file_exists($path)) {
            throw new \Exception("Template file not found: {$path}");
        }

        extract($this->data);

        ob_start();

        include $path;

        return ob_get_clean();
    }
}

