<?php
namespace Isoros\controllers\web;

use Isoros\controllers\api\UserRepository;
use Isoros\core\controller;
use Isoros\core\View;
use Isoros\routing\Request;
use Isoros\routing\Session;
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
        $userRepository = new UserRepository();

        // Hier haal je de gegevens op uit het inlogformulier
        $username = $request->getParams()["username"];
        $password = $request->getParams()["password"];

        echo "$username";
        $user = $userRepository->findUserByEmail($username);
        (new Session())->set('user', $username);
        echo "$user";

        if (!$user) {
            // Gebruiker niet gevonden
            echo "Ongeldige inloggegevens.";
            return;
        }

        header('Location: /home?message=login_success');
        exit();


        // Hier kun je de login logica uitvoeren
        // ...
    }
}