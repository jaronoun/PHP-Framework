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
    public Request $request;

    public $user = null;
    public $exams = null;
    public $selectedExamId;

    public function __construct(
        ExamUserRepository $examUserRepository ,
        ExamRepository $examRepository ,
        GradeRepository $gradeRepository,
        UserRepository $userRepository,
        View $view,
        Session $session,
        Request $request
    )
    {
        $this->examUserRepository = $examUserRepository;
        $this->examRepository = $examRepository;
        $this->gradeRepository = $gradeRepository;
        $this->userRepository = $userRepository;
        $this->view = $view;
        $this->session = $session;
        $this->request = $request;

        $email = $this->session->get('user');
        $this->user = $this->userRepository->findUserByEmail($email);
        $view->setController($this);
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
        $this->selectedExamId = $id;
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

    public function getGrade()
    {
        $userGrade = $this->gradeRepository->findGradeByExamIdAndUserId($this->selectedExamId, $this->user->id);
        return $userGrade;
    }

    public function hasGrade()
    {
        $userGrade = $this->getGrade();
        if ($userGrade) {
            return true;
        }
        return false;
    }

    public function storeGrade($id)
    {
        var_dump($id);
//        $data['user_id'] = $this->user->id;
//        $data['exam_id'] = $this->selectedExamId;
//        $this->gradeRepository->create($data);
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