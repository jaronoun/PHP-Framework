<?php
namespace Isoros\Controllers\web;

use Isoros\core\Controller;

require_once __DIR__ . '/../../../vendor/autoload.php';


class LoginController extends Controller
{
public function index()
    {
        // Start the output buffer
        ob_start();

        // Set the page title
        $title = "Login";

        // Include the view template
        include __DIR__ . '/../../views/auth/login.php';

        // Get the contents of the output buffer and flush it to the browser
        echo ob_get_clean();
    }
}