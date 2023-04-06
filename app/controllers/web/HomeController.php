<?php
namespace Isoros\Controllers\web;

use Isoros\core\Controller;

require_once __DIR__ . '/../../../vendor/autoload.php';


class HomeController extends Controller
{
    public function index()
    {
        // Start the output buffer
        ob_start();

        // Set the page title
        $title = "Home";

        // Include the header template
        include __DIR__ . '/../../views/layout/header.php';

        // Include the view template
        include __DIR__ . '/../../views/homepage/index.php';

        // Include the footer template
        include __DIR__ . '/../../views/layout/footer.php';

        // Get the contents of the output buffer and flush it to the browser
        echo ob_get_clean();
    }
}