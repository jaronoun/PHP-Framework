<?php

namespace Isoros\controllers\web;

use Exception;
use Isoros\controllers\api\ExamRepository;
use Isoros\controllers\api\ExamUserRepository;
use Isoros\controllers\api\UserRepository;
use Isoros\core\View;
use Isoros\models\User;
use Isoros\routing\Request;
use Isoros\routing\Response;
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

    }

    public function getUserExams()
    {
        $examUser = $this->examUserRepository->findByUser($this->user->getId());
        foreach ($examUser as $exam) {
            $exam = $this->examRepository->findById($exam['exam_id']);
            $this->exams[] = $exam[0];
        }
    }


    /**
     * @throws Exception
     */
    public function index(): void
    {
        $loggedIn = $this->session->get('loggedIn');
        $this->getUserExams();

        $this->view->render('exams/index.php', [
            'loggedIn' => $loggedIn,
            'page' => 'exams',
            'role' => $this->user->role,
            'exams' => $this->exams
        ]);

    }

    /**
     * @throws Exception
     */
    public function storeExam()
    {
        $data = $this->request->getParams();
        $this->examRepository->create($data);
        $exam = $this->examRepository->findExamByName($data['name']);

        $this->examUserRepository->create([
            'exam_id' => $exam->getId(),
            'user_id' => $this->user->id
        ]);

        $this->getUserExams();

        if (!$exam) {
            return new Response(502,[],"Er is iets fout gegaan");
        } else {
            $this->view->render('exams/index.php', [
                'loggedIn' => $this->session->get('loggedIn'),
                'role' => $this->user->role,
                'exams' => $this->exams,
                ]);

        }
    }

    /**
     * @throws Exception
     */
    public function removeExam($id): void
    {
        $this->examUserRepository->delete($id);
        $this->examRepository->delete($id);
        $this->getUserExams();

        $this->view->render('exams/index.php', [
            'loggedIn' => $this->session->get('loggedIn'),
            'role' => $this->user->role,
            'exams' => $this->exams
            ]);

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