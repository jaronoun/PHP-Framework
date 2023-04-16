<?php

namespace Isoros\controllers\web;

use Isoros\controllers\api\ExamRepository;
use Isoros\core\Controller;
use Isoros\core\View;
use Isoros\routing\Session;

class ExamController extends Controller
{


    public function show()
    {
        $session = $this->getContainer()->get(Session::class);
        $loggedIn = $session->get('loggedIn');
        $user = $session->get('user');

        $this->gradeRepository = new ExamRepository();
        $title = "Login";

        $container = $this->getContainer();

        $view = $container->get(View::class);


        $view->renderParams('exams/index',['user' => $user, 'loggedIn' => $loggedIn, 'page' => 'exams']);

    }
}