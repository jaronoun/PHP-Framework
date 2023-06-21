<?php

namespace Isoros\controllers\web;

use Isoros\controllers\api\ExamRepository;
use Isoros\controllers\api\ExamUserRepository;
use Isoros\controllers\api\UserRepository;
use Isoros\core\View;
use Isoros\models\User;
use Isoros\routing\Request;
use Isoros\routing\Session;

class ExamController
{

    public ExamRepository $examRepository;
    public ExamUserRepository $examUserRepository;
    public UserRepository $userRepository;
    public View $view;
    public Session $session;
    public Request $request;

    public ?User $user = null;
    public ?array $exams = null;


    public function __construct(
        ExamRepository $examRepository,
        UserRepository $userRepository,
        ExamUserRepository $examUserRepository,
        View $view,
        Session $session,
        Request $request)
    {
        $this->examUserRepository = $examUserRepository;
        $this->examRepository = $examRepository;
        $this->userRepository = $userRepository;
        $this->view = $view;
        $this->request = $request;
        $this->session = $session;

        $this->view->setController($this);
        $email = $this->session->get('user');
        $this->user = $this->userRepository->findUserByEmail($email);
        $this->exams = $this->examUserRepository->findByUser($this->user->getId());
    }

    public function index()
    {
        $loggedIn = $this->session->get('loggedIn');

        $result = $this->view->render('exams/index.php', [
            'loggedIn' => $loggedIn,
            'page' => 'exams',
            'role' => $this->user->role,
            'exams' => $this->exams
        ]);
        echo $result;
    }

    public function storeExam()
    {
        $data = $this->request->getParams();
        $this->examRepository->create($data);
        $exam = $this->examRepository->findExamByName($data['name']);

        $this->examUserRepository->create([
            'exam_id' => $exam->getId(),
            'user_id' => $this->user->id
        ]);

        $this->exams = $this->examUserRepository->findByUser($this->user->getId());

        if (!$exam) {
            echo "Er is iets fout gegaan";
        } else {
            $result = $this->view->render('exams/index.php', [
                'loggedIn' => $this->session->get('loggedIn'),
                'role' => $this->user->role,
                'exams' => $this->exams,
                ]);
            echo $result;
        }
    }

    public function removeExam($id)
    {
        $this->examUserRepository->delete($id);
        $this->examRepository->delete($id);
        $this->exams = $this->examUserRepository->findByUser($this->user->getId());

        $result = $this->view->render('exams/index.php', [
            'loggedIn' => $this->session->get('loggedIn'),
            'role' => $this->user->role,
            'exams' => $this->exams
            ]);
        echo $result;
    }

    public function getTime($dateTime)
    {
        $timestamp = strtotime($dateTime);
        $formattedTime = date('H:i', $timestamp);
        return $formattedTime;
    }

    public function getDate($dateTime)
    {
        $timestamp = strtotime($dateTime);
        $formattedDate = date('j F Y', $timestamp);
        return $formattedDate;
    }


}