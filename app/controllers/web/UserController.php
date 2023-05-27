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

    public function show()
    {

        $loggedIn = $this->session->get('loggedIn');
        $email = $this->session->get('user');

        $title = "Login";

        $user = $this->userRepository->findUserByEmail($email);

        $this->view->renderParams('users/index',['user' => $user, 'loggedIn' => $loggedIn, 'page' => 'users']);

//        $data = ['name' => $title, 'loggedIn' => $loggedIn, 'page' => 'users', 'user' => $user];

//        $view = new View(__DIR__ . '/../../../resources/views');
//        $result = $view->render('users/index.php', $data);

    }

    public function index()
    {
        // TODO: Implement index() method.
    }
}
