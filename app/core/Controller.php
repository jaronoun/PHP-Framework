<?php

namespace Isoros\core;

use ExamUserController;
use Isoros\controllers\api\ExamController;
use Isoros\Controllers\api\GradeController;
use Isoros\controllers\api\UserController;
use Psr\Container\ContainerInterface;

class Controller
{
    protected $userRepository;
    protected $gradeRepository;
    protected $examRepository;
    protected $examUserRepository;
    private ContainerInterface $container;

    public function __construct()
    {
        $this->container = Container::getInstance();

//        $this->userRepository = $this->container->get(UserController::class);
//        $this->gradeRepository = $this->container->get(UserController::class);
//        $this->examRepository = $this->container->get(UserController::class);
//        $this->examUserRepository = $this->container->get(UserController::class);

    }

    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

}
