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
        $this->view->render('auth/login.php', [
            'loggedIn' => $loggedIn,
            'title' => $title,
            'role' => ''
        ]);
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

        $user = $this->userRepository->findUserByEmail($username);

        if (!$user || !password_verify($password, $user->password)) {
            echo "Ongeldige inloggegevens.";
            $this->view->render('auth\login.php', [
                'username' => $username,
                'loggedIn' => false,
                'role' => $user->role
            ]);
            exit;
        }

        $this->session->set('user', $username);
        $this->session->set('loggedIn', true);

        if ($user->role == 'student') {
            $this->request->Redirect('/cijfers');
            $this->view->render('grades\index.php', [
                'username' => $username,
                'loggedIn' => $this->session->get('loggedIn'),
                'role' => $user->role
            ]);
        } else {
            $this->request->Redirect('/tentamens');
            $this->view->render('exams\index.php', [
                'username' => $username,
                'loggedIn' => $this->session->get('loggedIn'),
                'role' => $user->role
            ]);
        }


    }

    public function handleLogout()
    {
        $loggedIn = false;
        $this->session->destroy();
        $this->view->render('auth\login.php', [
            'loggedIn' => $loggedIn,
            'role' => ''
        ]);
    }

}