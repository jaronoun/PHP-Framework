<?php
namespace Isoros\Controllers\web;

use Isoros\core\Controller;
use Isoros\routing\Request;

require_once __DIR__ . '/../../../vendor/autoload.php';


class LoginController extends Controller
{
    public function index()
    {
        $request = $this->container->get(Request::class);
        $request->getMethod();

        // Start the output buffer
        ob_start();

        // Set the page title
        $title = "Login";
        echo '<pre>';
        var_dump($request);
        echo '</pre>';

        // Include the header template
        include __DIR__ . '/../../views/layout/header.php';

        // Include the view template
        include __DIR__ . '/../../views/auth/login.php';


        // Get the contents of the output buffer and flush it to the browser
        echo ob_get_clean();
    }

    public function show()
    {
        $request = $this->container->get(Request::class);
        $body = $request->getParam('username');

        // Start the output buffer
        ob_start();

        // Set the page title
        $title = "Login";
        echo '<pre>';
        var_dump($request);
        echo '</pre>';

        // Include the header template
        include __DIR__ . '/../../views/layout/header.php';

        // Include the view template
        include __DIR__ . '/../../views/auth/login.php';


        // Get the contents of the output buffer and flush it to the browser
        echo ob_get_clean();
    }


}