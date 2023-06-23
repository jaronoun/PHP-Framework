<?php
namespace Isoros\controllers\web;

use Isoros\controllers\api\ExamRepository;
use Isoros\controllers\api\ExamUserRepository;
use Isoros\controllers\api\GradeRepository;
use Isoros\controllers\api\Repository;
use Isoros\controllers\api\UserRepository;
use Isoros\core\Controller;
use Isoros\core\View;
use Isoros\routing\Request;
use Isoros\routing\Session;

class GradeController
{
    public Repository $examRepository;
    public Repository $examUserRepository;
    public Repository $gradeRepository;
    public Repository $userRepository;
    public View $view;
    public Session $session;

    public $user = null;
    public $exams = null;

    public function __construct(ExamUserRepository $examUserRepository ,ExamRepository $examRepository ,GradeRepository $gradeRepository, UserRepository $userRepository, View $view, Session $session)
    {
        $this->examUserRepository = $examUserRepository;
        $this->examRepository = $examRepository;
        $this->gradeRepository = $gradeRepository;
        $this->userRepository = $userRepository;
        $this->view = $view;
        $this->session = $session;

        $email = $this->session->get('user');
        $this->user = $this->userRepository->findUserByEmail($email);
    }

    public function getUserExams()
    {
        $examUser = $this->examUserRepository->findByUser($this->user->id);
        foreach ($examUser as $exam) {
            $exam = $this->examRepository->findById($exam['exam_id']);
            $this->exams[] = $exam;
        }
    }

    public function getExamUsers($id)
    {
        $loggedIn = SESSION::get('loggedIn');
        $exam = $this->examRepository->findById($id);
        $examUsers = $this->examUserRepository->findByExam($id);
        $users = [];
        foreach ($examUsers as $examUser) {
            $user = $this->userRepository->findById($examUser['user_id']);
            $users[] = $user;
        }

        $this->getUserExams();

        $this->view->render('grading/index.php', [
            'loggedIn' => $loggedIn,
            'user' => $this->user,
            'users' => $users,
            'exams' => $this->exams,
            'ex' => $exam
        ]);
    }

    public function show()
    {
        $loggedIn = SESSION::get('loggedIn');

        $grades = $this->gradeRepository->getAll();

        $this->view->render('grades/index.php', [
            'loggedIn' => $loggedIn,
            'user' => $this->user,
            'data' => $grades
        ]);
    }

    public function showExams()
    {
        $loggedIn = SESSION::get('loggedIn');

        $this->getUserExams();

        $this->view->render('grading/index.php', [
            'loggedIn' => $loggedIn,
            'user' => $this->user,
            'exams' => $this->exams,
        ]);
    }
}