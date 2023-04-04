<?php
namespace Isoros\Controllers\web;

use Isoros\Core\Controller;
use Isoros\Core\View;

require_once __DIR__ . '/../../../vendor/autoload.php';


class HomeController extends Controller
{
    public function index()
    {
        $view = new View('homepage/index', compact(''));
        $view->render();
    }

    public function show()
    {
        echo "Welcome to the home page!";
    }
}