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
        //extract($this->data);
        ob_start();

        // Set the page title
        $title = "";
        $loggedIn = false;

        // Include the header template
        include __DIR__ . '/../views/layout/header.php';

        // Include the view template
        include __DIR__ . "/../views/{$view}.php";

        // Include the footer template
        include __DIR__ . '/../views/layout/footer.php';

        // Get the contents of the output buffer and flush it to the browser
        echo ob_get_clean();

    }

    public function renderParams($view, $data = [])
    {
        // Extract the data so it's available in the view
        extract($data);

        // Start the output buffer
        ob_start();

        // Set the page title
        $title = "Home";

        // Include the header template
        include __DIR__ . '/../views/layout/header.php';

        // Include the view template
        include __DIR__ . "/../views/{$view}.php";

        // Include the footer template
        include __DIR__ . '/../views/layout/footer.php';

        // Get the contents of the output buffer and flush it to the browser
        echo ob_get_clean();
    }
}

