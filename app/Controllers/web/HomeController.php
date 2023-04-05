<?php
namespace Isoros\Controllers\web;

use Isoros\Core\Controller;

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
        include __DIR__ . '/../../Views/layout/header.php';
        ?>

        <div class="container">
            <h1>Welcome to the home page!</h1>
        </div>

        <?php
        // Include the footer template
        include __DIR__ . '/../../views/layout/footer.php';

        // Get the contents of the output buffer and flush it to the browser
        echo ob_get_clean();
    }
}