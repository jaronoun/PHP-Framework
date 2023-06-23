<?php
namespace Isoros\controllers\web;

use Isoros\Controllers\api\GradeRepository;
use Isoros\controllers\api\Repository;
use Isoros\controllers\api\UserRepository;
use Isoros\core\View;
use Isoros\models\User;
use Isoros\routing\Session;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class UserController
{
    public UserRepository $userRepository;
    public View $view;
    public Session $session;
    public function __construct(UserRepository $repository, View $view, Session $session)
    {

        $this->userRepository = $repository;
        $this->view = $view;
        $this->session = $session;
    }

    public function index()
    {
        $loggedIn = $this->session->get('loggedIn');
        $title = "Login";
        $email = $this->session->get('user');
        $user = $this->userRepository->findUserByEmail($email);
        if($user->getRole() == 'admin'){
            $data = $this->userRepository->getAll();
        } else {
            $data = null;
        }

        $this->view->render('users/index.php', ['loggedIn' => $loggedIn, 'title' => $title, 'name' => $user->name, 'email' => $user->email, 'role' => $user->role, 'data' => $data]);

    }

}
