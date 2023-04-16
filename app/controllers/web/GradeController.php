<?php
namespace Isoros\controllers\web;

use Isoros\controllers\api\GradeRepository;
use Isoros\core\Controller;
use Isoros\core\View;
use Isoros\routing\Request;
use Isoros\routing\Session;

class GradeController extends Controller
{
    public function index()
    {
        var_dump($this->getContainer()->get(Session::class)->get('user'));
        $this->gradeRepository = new GradeRepository();
        $title = "Login";

        $container = $this->getContainer();

        $view = $container->get(View::class);


        $view->render('grades/index');

    }

    public function show()
    {
        $session = $this->getContainer()->get(Session::class);
        $loggedIn = $session->get('loggedIn');
        $user = $session->get('user');

        $this->gradeRepository = new GradeRepository();
        $title = "Login";

        $container = $this->getContainer();

        $view = $container->get(View::class);


        $view->renderParams('grades/index',['user' => $user, 'loggedIn' => $loggedIn]);

    }
}