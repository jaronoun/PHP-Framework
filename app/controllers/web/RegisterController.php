<?php
namespace Isoros\controllers\web;

use Isoros\controllers\api\Repository;
use Isoros\core\View;
use Isoros\routing\Request;
use Isoros\controllers\api\UserRepository;
use Isoros\routing\Session;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

require_once __DIR__ . '/../../../vendor/autoload.php';



class RegisterController
{

    public Request $request;
    public Session $session;
    public View $view;
    public UserRepository $userRepository;

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
            $title = "Register";
            $role = '';
            $result = $this->view->render('auth/register.php', ['title' => $title, 'loggedIn' => false, 'role' => $role]);
            echo $result;
        }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function handleRegister()
    {
        $data = $this->request->getParams();
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $user = $this->userRepository->create($data);
        $role = $user->role;

        if(!$user){
            echo "Er is iets fout gegaan";
            $result = $this->view->render('auth\register.php', ['loggedIn' => $this->session->get('loggedIn'), 'role' => $role]);
            echo $result;

        } else {
            $session = $this->session;
            $session->set('user', $this->request->getParams()["email"]);
            $session->set('loggedIn', true);
            $result = $this->view->render('grades\index.php', ['loggedIn' => $this->session->get('loggedIn'), 'role' => $role]);
            echo $result;
            exit;
        }

    }
}