<?php

namespace Isoros\controllers\web;

use Isoros\controllers\api\ExamRepository;
use Isoros\controllers\api\UserRepository;
use Isoros\core\View;
use Isoros\routing\Session;

class ExamController
{

    public ExamRepository $examRepository;
    public UserRepository $userRepository;
    public View $view;
    public Session $session;

    public function __construct(ExamRepository $examRepository, UserRepository $userRepository, View $view, Session $session)
    {
        $this->examRepository = $examRepository;
        $this->userRepository = $userRepository;
        $this->view = $view;
        $this->session = $session;
    }

    public function index()
    {
        $loggedIn = SESSION::get('loggedIn');
        $email = $this->session->get('user');
        $user = $this->userRepository->findUserByEmail($email);
        $result = $this->view->render('exams/index.php', ['user' => $user, 'loggedIn' => $loggedIn, 'page' => 'exams', 'role' => $user->role]);
        echo $result;
    }

    public function show()
    {
        $loggedIn = SESSION::get('loggedIn');
        $email = $this->session->get('user');
        $user = $this->userRepository->findUserByEmail($email);
    }
}