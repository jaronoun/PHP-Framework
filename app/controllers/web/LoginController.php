<?php
namespace Isoros\controllers\web;

use Isoros\core\controller;
use Isoros\core\View;

require_once __DIR__ . '/../../../vendor/autoload.php';

class LoginController extends Controller
{
    public function index()
        {
            $title = "Login";

            $view = $this->container->get(View::class);
            $view->render('auth/login');

//            echo '<pre>';
//            var_dump($request);
//            echo '</pre>';
        }
}