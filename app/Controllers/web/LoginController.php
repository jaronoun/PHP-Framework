<?php
namespace Isoros\Controllers\web;

use Isoros\Core\Controller;

require_once __DIR__ . '/../../../vendor/autoload.php';


class LoginController extends Controller
{
public function index()
    {
        // Start the output buffer
        ob_start();

        // Set the page title
        $title = "Login";

        // Include the header template
        include __DIR__ . '/../../Views/layout/header.php';

        // Include the view template
        include __DIR__ . '/../../Views/auth/login.php';


        // Get the contents of the output buffer and flush it to the browser
        echo ob_get_clean();
    }
}