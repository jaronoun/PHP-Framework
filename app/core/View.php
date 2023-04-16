<?php

namespace Isoros\core;

class View
{
    protected $view;
    protected $data = [];

    public function __construct()
    {

    }

    public function render($view): void
    {
        // Set the page title

        //extract($this->data);
        $data = ['title' => "", 'loggedIn' => false, 'page' => ""];
        extract($data);
        ob_start();

        include __DIR__ . '/../views/layout/header.php';
        include __DIR__ . "/../views/{$view}.php";
        include __DIR__ . '/../views/layout/footer.php';

        echo ob_get_clean();

    }

    public function renderParams($view, $data = [])
    {
        extract($data);

        ob_start();

        $title = "Home";

        include __DIR__ . '/../views/layout/header.php';
        include __DIR__ . "/../views/{$view}.php";
        include __DIR__ . '/../views/layout/footer.php';

        echo ob_get_clean();
    }
}

