<?php
namespace Isoros\controllers\web;

use Isoros\controllers\api\GradeRepository;
use Isoros\core\Controller;
use Isoros\core\View;

class GradeController extends Controller
{
    public function index()
    {
        $this->gradeRepository = new GradeRepository();
        $title = "Login";

        $container = $this->getContainer();

        $view = $container->get(View::class);


        $view->render('grades/index');

    }

    public function show()
    {
        $this->gradeRepository = new GradeRepository();
        $title = "Login";

        $container = $this->getContainer();

        $view = $container->get(View::class);


        $view->render('grades/index');

    }
}