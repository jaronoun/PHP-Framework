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



class LoginController
{
    public UserRepository $userRepository;
    public View $view;
    public Request $request;
    public Session $session;

    public function __construct(UserRepository $repository, View $view, Request $request, Session $session)
    {

        $this->userRepository = $repository;
        $this->view = $view;
        $this->request = $request;
        $this->session = $session;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index()
    {
        $title = "Login";
        $loggedIn = false;

        $result = $this->view->render('auth\login.php',['loggedIn' => $loggedIn, 'title' => $title]);

        echo $result;

    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function handleLogin()
    {
        // Hier haal je de gegevens op uit het inlogformulier
        $username = $this->request->getParams()["username"];
        $password = $this->request->getParams()["password"];
        var_dump($username);

        $user = $this->userRepository->findUserByEmail($username);

        if (!$user || !password_verify($user->password, $password)) {
            echo "Ongeldige inloggegevens.";
            $this->view->render('auth\login.php', ['username' => $username]);
        }

        $this->session->set('user', $username);
        $this->session->set('loggedIn', true);


        header('Location: /cijfers');
        exit;
    }

    public function handleLogout()
    {

        $loggedIn = false;
        $this->session->destroy();
        $this->view->render('auth\login.php', ['loggedIn' => $loggedIn]);
        header('Location: /login');
        //        $this->view->renderParams('auth/login',[  ]);
    }

}