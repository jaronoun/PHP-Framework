<?php
namespace Isoros\controllers\web;

use Isoros\core\controller;
use Isoros\core\View;
use Isoros\routing\Request;

require_once __DIR__ . '/../../../vendor/autoload.php';

class LoginController extends Controller
{
    public function index()
        {
            $title = "Login";

            $container = $this->getContainer();

            $view = $container->get(View::class);

            $view->render('auth/login');

        }

    public function handleLogin()
    {
        $request = $this->getContainer()->get(Request::class);

        // Hier haal je de gegevens op uit het inlogformulier
        $username = $request->getParams()["username"];

        $password = $request->getParams()["password"];

        echo "Je bent nu ingelogd met username: '$username' en wachtwoord: '$password'";

        // Hier kun je de login logica uitvoeren
        // ...
    }
}