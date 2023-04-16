<?php

namespace Isoros\controllers\web;

use Isoros\controllers\api\ExamRepository;
use Isoros\core\Controller;
use Isoros\core\View;

class ExamController extends Controller
{
    public function index()
    {
        $this->gradeRepository = new ExamRepository();
        $title = "Login";

        $container = $this->getContainer();

        $view = $container->get(View::class);


        $view->render('exams/index');

    }

    public function show()
    {
        $this->gradeRepository = new ExamRepository();
        $title = "Login";

        $container = $this->getContainer();

        $view = $container->get(View::class);


        $view->render('exams/index');

    }
}