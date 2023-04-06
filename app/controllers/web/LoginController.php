<?php
namespace Isoros\Controllers\web;

use Isoros\core\Controller;

require_once __DIR__ . '/../../../vendor/autoload.php';

use Isoros\core\Controller;
use Isoros\core\View;

class LoginController extends Controller
{
public function index()
    {
        $title = "Login";
        echo '<pre>';
        var_dump($request);
        echo '</pre>';

        $view = new View('auth/login');
        $view->render();
    }
}