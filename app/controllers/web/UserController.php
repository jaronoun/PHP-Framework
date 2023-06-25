<?php
namespace Isoros\controllers\web;

use Isoros\Controllers\api\GradeRepository;
use Isoros\controllers\api\Repository;
use Isoros\controllers\api\UserRepository;
use Isoros\core\View;
use Isoros\models\User;
use Isoros\routing\Session;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class UserController
{
    public UserRepository $userRepository;
    public GradeRepository $gradeRepository;
    public View $view;
    public Session $session;
    public $user;
    public function __construct(UserRepository $repository, GradeRepository $gradeRepository, View $view, Session $session)
    {
        $this->gradeRepository = $gradeRepository;
        $this->userRepository = $repository;
        $this->view = $view;
        $this->session = $session;

        $email = $this->session->get('user');
        $this->user = $this->userRepository->findUserByEmail($email);
    }

    public function index()
    {
        $loggedIn = $this->session->get('loggedIn');
        $title = "Login";

        if($this->user->getRole() == 'admin'){
            $allUsers = $this->userRepository->getAll();
            $allEnrollments = $this->gradeRepository->getAll();
        } else {
            $data = null;
        }

        $this->view->render('users/index.php', [
            'loggedIn' => $loggedIn,
            'title' => $title,
            'user' => $this->user,
            'allUsers' => $allUsers,
            'allEnrollments' => $allEnrollments
        ]);

    }

}
