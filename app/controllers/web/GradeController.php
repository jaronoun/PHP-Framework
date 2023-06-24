<?php
namespace Isoros\controllers\web;

use http\Client\Curl\User;
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
    public $grades = null;
    public $users = null;
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
    public function showExamUsers($id)
    {
        $loggedIn = SESSION::get('loggedIn');
        $this->selectedExamId = $id;
        $exam = $this->examRepository->findById($id);

        $this->getUserExams();

        $this->view->render('grading/index.php', [
            'loggedIn' => $loggedIn,
            'user' => $this->user,
            'users' => $this->users,
            'exams' => $this->exams,
            'ex' => $exam
        ]);
    }

    public function show()
    {
        $loggedIn = SESSION::get('loggedIn');

        $allGrades = $this->gradeRepository->getAll();
        $grades = $this->gradeRepository->findByUserId($this->user->id);

        $grade = $this->gradeRepository->findRecentGrade($this->user->id);
        $grade['exam_id'] = $this->gradeRepository->findExamName($grade['exam_id']);
        $grade['teacher_id'] = $this->gradeRepository->findUserName($grade['teacher_id']);

        $this->getUserExams();

        $this->view->render('grades/index.php', [
            'loggedIn' => $loggedIn,
            'user' => $this->user,
            'data' => $allGrades,
            'grades' => $grades,
            'grade' => $grade,
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

    public function storeGrade($examID, $userID)
    {
        $loggedIn = SESSION::get('loggedIn');

        $data['exam_id'] = intval($examID);
        $data['user_id'] = intval($userID);
        $data['teacher_id'] = $this->user->id;
        $data['grade'] = intval($this->request->getParam('grade'));

        $existingGrade = $this->gradeRepository->findGradeByExamIdAndUserId($examID, $userID);
        if ($existingGrade)
        {
            $this->gradeRepository->update($existingGrade['id'], $data);
        }
        else
        {
            $this->gradeRepository->create($data);
        }


        $this->selectedExamId = $examID;
        $exam = $this->examRepository->findById($this->selectedExamId);
        $this->getUserExams();

        $this->view->render('grading/index.php', [
            'loggedIn' => $loggedIn,
            'user' => $this->user,
            'users' => $this->users,
            'exams' => $this->exams,
            'ex' => $exam
        ]);
    }


    public function getUserExams()
    {
        $examUser = $this->examUserRepository->findByUser($this->user->id);
        foreach ($examUser as $exam) {
            $exam = $this->examRepository->findById($exam['exam_id']);
            $this->exams[] = $exam;
        }
        if ($this->selectedExamId) {
            $examUsers = $this->examUserRepository->findByExam($this->selectedExamId);
            foreach ($examUsers as $examUser) {
                $user = $this->userRepository->findById($examUser['user_id']);
                $this->users[] = $user;
            }
        }
    }

    public function getGrade($userID)
    {
        $userGrade = $this->gradeRepository->findGradeByExamIdAndUserId($this->selectedExamId, $userID);
        if ($userGrade)
        {
            return $userGrade['grade'];
        }
        return $userGrade;
    }

    public function hasGrade($userID)
    {
        $userGrade = $this->gradeRepository->findGradeByExamIdAndUserId($this->selectedExamId, $userID);
        if ($userGrade)
        {
            return true;
        }
        return false;
    }

    public function getSelectedExamId()
    {
        return $this->selectedExamId;
    }

    public function getDate($dateTime)
    {
        $timestamp = strtotime($dateTime);
        $formattedDate = date('j F Y', $timestamp);
        return $formattedDate;
    }

}