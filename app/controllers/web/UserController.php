<?php
namespace Isoros\controllers\web;

use Isoros\controllers\api\ExamRepository;
use Isoros\controllers\api\ExamUserRepository;
use Isoros\Controllers\api\GradeRepository;
use Isoros\controllers\api\Repository;
use Isoros\controllers\api\UserRepository;
use Isoros\core\View;
use Isoros\models\User;
use Isoros\routing\Request;
use Isoros\routing\Session;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class UserController
{
    public UserRepository $userRepository;
    public GradeRepository $gradeRepository;
    public ExamUserRepository $examUserRepository;
    public ExamRepository $examRepository;
    public Request $request;
    public View $view;
    public Session $session;
    public $user;
    public $allUsers;
    public $allEnrollments;
    public $allExams;

    public function __construct(
        UserRepository $repository,
        GradeRepository $gradeRepository,
        ExamUserRepository $examUserRepository,
        ExamRepository $examRepository,
        View $view,
        Session $session,
        Request $request
    )
    {
        $this->gradeRepository = $gradeRepository;
        $this->examUserRepository = $examUserRepository;
        $this->examRepository = $examRepository;
        $this->userRepository = $repository;
        $this->view = $view;
        $this->session = $session;
        $this->request = $request;

        $email = $this->session->get('user');
        $this->user = $this->userRepository->findUserByEmail($email);
    }

    public function index()
    {
        $loggedIn = $this->session->get('loggedIn');
        $this->getUsers();

        $this->view->render('users/index.php', [
            'loggedIn' => $loggedIn,
            'user' => $this->user,
            'allUsers' => $this->allUsers,
            'allEnrollments' => $this->allEnrollments,
            'allExams' => $this->allExams
        ]);
    }

    public function store()
    {
        $loggedIn = $this->session->get('loggedIn');

        $data = $this->request->getParams();
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $this->userRepository->create($data);

        $this->getUsers();

        $this->view->render('users/index.php', [
            'loggedIn' => $loggedIn,
            'user' => $this->user,
            'allUsers' => $this->allUsers,
            'allEnrollments' => $this->allEnrollments,
            'allExams' => $this->allExams
        ]);
    }

    public function enrollUser()
    {
        $loggedIn = $this->session->get('loggedIn');
        $this->examUserRepository->create($this->request->getParams());
        $this->getUsers();

        $this->view->render('users/index.php', [
            'loggedIn' => $loggedIn,
            'user' => $this->user,
            'allUsers' => $this->allUsers,
            'allEnrollments' => $this->allEnrollments,
            'allExams' => $this->allExams
        ]);
    }

    public function update($userID)
    {
        $loggedIn = $this->session->get('loggedIn');
        $this->userRepository->update($userID, $this->request->getParams());
        $this->getUsers();

        $this->view->render('users/index.php', [
            'loggedIn' => $loggedIn,
            'user' => $this->user,
            'allUsers' => $this->allUsers,
            'allEnrollments' => $this->allEnrollments,
            'allExams' => $this->allExams
        ]);
    }

    public function delete($userID)
    {
        $loggedIn = $this->session->get('loggedIn');
        $this->userRepository->delete($userID);
        $this->getUsers();

        $this->view->render('users/index.php', [
            'loggedIn' => $loggedIn,
            'user' => $this->user,
            'allUsers' => $this->allUsers,
            'allEnrollments' => $this->allEnrollments,
            'allExams' => $this->allExams
        ]);
    }

    public function deleteEnrollment($enrollID)
    {
        $loggedIn = $this->session->get('loggedIn');
        $this->examUserRepository->deleteId($enrollID);
        $this->getUsers();

        $this->view->render('users/index.php', [
            'loggedIn' => $loggedIn,
            'user' => $this->user,
            'allUsers' => $this->allUsers,
            'allEnrollments' => $this->allEnrollments,
            'allExams' => $this->allExams
        ]);
    }

    public function getUsers()
    {
        if ($this->user->getRole() == 'admin') {
            $this->allUsers = $this->userRepository->getAll();
            $this->allEnrollments = $this->examUserRepository->getAll();
            $this->allExams = $this->examRepository->getAll();
        }
    }

}
