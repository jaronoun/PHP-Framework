<?php
namespace Isoros\controllers\web;

require_once __DIR__ . '/../../../vendor/autoload.php';

use Isoros\core\Controller;
use Isoros\core\View;

class LoginController extends Controller
{

    public function index()
    {
        $view = new View('auth/login');
        $view->render();
    }
}