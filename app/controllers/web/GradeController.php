<?php
namespace Isoros\controllers\web;

use Isoros\controllers\api\GradeRepository;
use Isoros\controllers\api\UserRepository;
use Isoros\core\Controller;
use Isoros\core\View;
use Isoros\routing\Request;
use Isoros\routing\Session;

class GradeController extends Controller
{

    public function __construct(GradeRepository $gradeRepository, UserRepository $userRepository, Session $session, View $view)
    {
        $this->gradeRepository = $gradeRepository;
        $this->userRepository = $userRepository;
        $this->session = $session;
        $this->view = $view;
    }

    public function show()
    {
        $session = $this->getContainer()->get(Session::class);
        $loggedIn = $session->get('loggedIn');

        $userRepository = new UserRepository();
        $user = $userRepository->findUserByEmail($session->get('user'));

        $gradeRepository = new GradeRepository();
        $data = $gradeRepository->findGradeByUser($user->getId());

        $view = $this->getContainer()->get(View::class);
        $view->renderParams('grades/index',['gradeRepo' => $gradeRepository, 'data' => $data, 'loggedIn' => $loggedIn, 'page' => 'grades']);

    }
}