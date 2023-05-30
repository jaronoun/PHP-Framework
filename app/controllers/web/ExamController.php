<?php

namespace Isoros\controllers\web;

use Isoros\controllers\api\ExamRepository;
use Isoros\controllers\api\Repository;
use Isoros\core\Controller;
use Isoros\core\View;
use Isoros\routing\Request;
use Isoros\routing\Session;

class ExamController
{

    public ExamRepository $examRepository;
    public View $view;

    public function __construct(ExamRepository $examRepository, View $view)
    {
        $this->examRepository = $examRepository;
        $this->view = $view;
    }

    public function index()
    {
        $loggedIn = SESSION::get('loggedIn');
        $user = SESSION::get('user');

        $result = $this->view->render('exams/index.php', ['user' => $user, 'loggedIn' => $loggedIn, 'page' => 'exams']);
        echo $result;
    }

    public function show()
    {
        $loggedIn = SESSION::get('loggedIn');
        $user = SESSION::get('user');

        $name = $this->request->getParams()['exam-name'];
        $exam = $this->examRepository->findExamByName($name);
    }
}