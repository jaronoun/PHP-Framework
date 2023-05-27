<?php
namespace Isoros\controllers\web;

use Isoros\controllers\api\GradeRepository;
use Isoros\controllers\api\Repository;
use Isoros\controllers\api\UserRepository;
use Isoros\core\Controller;
use Isoros\core\View;
use Isoros\routing\Request;
use Isoros\routing\Session;

class GradeController
{
    public Repository $gradeRepository;
    public Repository $userRepository;
    public View $view;
    public Session $session;

    public function __construct(GradeRepository $gradeRepository, UserRepository $userRepository, View $view, Session $session)
    {

        $this->gradeRepository = $gradeRepository;
        $this->userRepository = $userRepository;
        $this->view = $view;
        $this->session = $session;
    }


    public function show()
    {

        $loggedIn = SESSION::get('loggedIn');

//        $user = $this->userRepository->findUserByEmail($this->session->get('user'));

//        $data = $this->gradeRepository->findGradeByUserId($user->getId());

        $result = $this->view->render('grades/index.php', []);
        echo $result;

//       $view->renderParams('grades/index',['user' => $user, 'loggedIn' => $loggedIn, 'page' => 'grades']);

    }
}