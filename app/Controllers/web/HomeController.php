<?php
namespace Isoros\Controllers\web;

use Isoros\Core\Controller;

require_once __DIR__ . '/../../../vendor/autoload.php';


class HomeController extends Controller
{
    public function index()
    {
        echo "Welcome to the home page!";
    }

    public function show()
    {
        echo "Welcome to the home page!";
    }
}