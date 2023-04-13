<?php
namespace Isoros\controllers\web;

use Isoros\core\controller;
use Isoros\core\View;
use Isoros\routing\Request;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

require_once __DIR__ . '/../../../vendor/autoload.php';



class LoginController extends Controller
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index()
        {
            $title = "Login";
            $container = $this->getContainer();
            $view = $container->get(View::class);
            $view->render('auth/login');
        }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function handleLogin()
    {
        $request = $this->getContainer()->get(Request::class);
        $userRepository = $this->getContainer()->get(UserRepository::class);

        // Hier haal je de gegevens op uit het inlogformulier
        $username = $request->getParams()["username"];
        $password = $request->getParams()["password"];

        echo "$username";
        $user = $userRepository->findUserByEmail($username);

        echo "$user";

        if (!$user) {
            // Gebruiker niet gevonden
            echo "Ongeldige inloggegevens.";
            return;
        }

        echo "<pre>";
        echo "$username";
        echo "\n";
        echo "$password";

        echo "$user";

        // Hier kun je de login logica uitvoeren
        // ...
    }
}