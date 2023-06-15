<?php

namespace Isoros\controllers\web;

use Isoros\controllers\api\ExamRepository;
use Isoros\controllers\api\ExamUserRepository;
use Isoros\controllers\api\UserRepository;
use Isoros\core\View;
use Isoros\routing\Request;
use Isoros\routing\Session;

class ExamController
{

    public ExamRepository $examRepository;
    public ExamUserRepository $examUserRepository;
    public UserRepository $userRepository;
    public View $view;
    public Session $session;
    public Request $request;

    public function __construct(
        ExamRepository $examRepository,
        UserRepository $userRepository,
        ExamUserRepository $examUserRepository,
        View $view,
        Session $session,
        Request $request)
    {
        $this->examUserRepository = $examUserRepository;
        $this->examRepository = $examRepository;
        $this->userRepository = $userRepository;
        $this->view = $view;
        $this->request = $request;
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

    public function storeExam()
    {
        $email = $this->session->get('user');
        $user = $this->userRepository->findUserByEmail($email);

        $data = $this->request->getParams();
        $exam = $this->examRepository->create($data);
        if (!$exam) {
            echo "Er is iets fout gegaan";
            $result = $this->view->render('exams/index.php', ['loggedIn' => $this->session->get('loggedIn'), 'role' => $user->role]);
            echo $result;
        } else {
            $result = $this->view->render('exams/index.php', ['loggedIn' => $this->session->get('loggedIn'), 'role' => $user->role]);
            echo $result;
        }
    }
}