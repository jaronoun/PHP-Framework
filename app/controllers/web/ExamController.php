<?php

namespace Isoros\controllers\web;

use Isoros\controllers\api\ExamRepository;
use Isoros\controllers\api\ExamUserRepository;
use Isoros\controllers\api\UserRepository;
use Isoros\core\View;
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
    }

    public function index()
    {
        $loggedIn = $this->session->get('loggedIn');
        $email = $this->session->get('user');
        $user = $this->userRepository->findUserByEmail($email);
        $exams = $this->examUserRepository->findByUser($user->getId());
        var_dump($exams);

        $result = $this->view->render('exams/index.php', [
            'loggedIn' => $loggedIn,
            'page' => 'exams',
            'role' => $user->role,
            'exams' => $exams
        ]);
        echo $result;
    }

    public function storeExam()
    {
        $email = $this->session->get('user');
        $user = $this->userRepository->findUserByEmail($email);

        $data = $this->request->getParams();
        $this->examRepository->create($data);

        $exam = $this->examRepository->findExamByName($data['name']);
        $this->examUserRepository->create([
            'exam_id' => $exam->getId(),
            'user_id' => $user->id
        ]);

        if (!$exam) {
            echo "Er is iets fout gegaan";
        } else {
            $result = $this->view->render('exams/index.php', [
                'loggedIn' => $this->session->get('loggedIn'),
                'role' => $user->role,
                'exams' => $exam,
                ]);
            echo $result;
        }
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
        $formattedDate = date('Y-m-d', $timestamp);
        return $formattedDate;
    }
}