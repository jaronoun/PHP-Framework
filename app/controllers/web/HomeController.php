<?php
namespace Isoros\Controllers\web;

use Isoros\core\Controller;
use Isoros\core\View;

require_once __DIR__ . '/../../../vendor/autoload.php';


class HomeController extends Controller
{
    public function index()
    {
        $title = "Login";

        $container = $this->getContainer();

        $view = $container->get(View::class);


        $view->render('homepage/index');

    }
}