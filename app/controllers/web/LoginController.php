<?php
namespace Isoros\controllers\web;

use Isoros\controllers\api\UserRepository;
use Isoros\core\controller;
use Isoros\core\View;
use Isoros\models\User;
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
        $view = $this->getContainer()->get(View::class);
        $userRepository = new UserRepository();

        // Hier haal je de gegevens op uit het inlogformulier
        $username = $request->getParams()["username"];
        $password = $request->getParams()["password"];

        $user = $userRepository->findUserByEmail($username);

        if (!$user) {
            echo "Ongeldige inloggegevens.";
            $view->render('auth/login');
        }
        (new Session())->set('user', $username);
        $loggedIn = true;
        $view->renderParams('grades/index',['user' => $user, 'loggedIn' => $loggedIn]);
        header('Location: /cijfers');
        exit;
    }

    public function handleLogout()
    {
        $view = $this->getContainer()->get(View::class);
        $loggedIn = false;
        (new Session())->destroy();
        $view->renderParams('auth/login',['loggedIn' => $loggedIn]);
    }

}