<?php

namespace Isoros\controllers\web;

use Isoros\controllers\api\ExamRepository;
use Isoros\core\Controller;
use Isoros\core\View;
use Isoros\routing\Request;
use Isoros\routing\Session;

class ExamController extends Controller
{


    public function index()
    {
        $container = $this->getContainer();
        $view = $container->get(View::class);

        $session = $container->get(Session::class);
        $loggedIn = $session->get('loggedIn');
        $user = $session->get('user');

        $this->examRepository = new ExamRepository();


        $view->renderParams('exams/index',['user' => $user, 'loggedIn' => $loggedIn, 'page' => 'exams']);

    }

    public function show()
    {
        $container = $this->getContainer();
        $view = $container->get(View::class);

        $session = $container->get(Session::class);
        $loggedIn = $session->get('loggedIn');
        $user = $session->get('user');

        $this->examRepository = new ExamRepository();
        $request= $container->get(Request::class);
        $name = $request->getParams()['exam-name'];
        $exam = $this->examRepository->findExamByName($name);

        $view->renderParams('exams/show',['user' => $user, 'loggedIn' => $loggedIn, 'page' => 'exams', 'exam' => $exam]);
    }
}