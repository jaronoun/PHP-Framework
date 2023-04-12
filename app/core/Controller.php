<?php

namespace Isoros\core;

use ExamUserRepository;
use Isoros\controllers\api\ExamRepository;
use Isoros\Controllers\api\GradeRepository;
use Isoros\controllers\api\UserRepository;
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

//        $this->userRepository = $this->container->get(UserRepository::class);
//        $this->gradeRepository = $this->container->get(UserRepository::class);
//        $this->examRepository = $this->container->get(UserRepository::class);
//        $this->examUserRepository = $this->container->get(UserRepository::class);

    }

    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

}
