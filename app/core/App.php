<?php

namespace Isoros\core;

use Isoros\controllers\api\ExamRepository;
use Isoros\controllers\api\ExamUserRepository;
use Isoros\controllers\api\GradeRepository;
use Isoros\controllers\api\Repository;
use Isoros\controllers\api\UserRepository;
use Isoros\controllers\web\ControllerFactory;
use Isoros\controllers\web\ControllerFactoryInterface;
use Isoros\controllers\web\ExamController;
use Isoros\controllers\web\GradeController;
use Isoros\controllers\web\LoginController;
use Isoros\controllers\web\RegisterController;
use Isoros\controllers\web\UserController;
use Isoros\core\Container;
use Isoros\core\Database;
use Isoros\core\Model;
use Isoros\core\View;

use Isoros\routing\Request;
use Isoros\routing\Router;
use Isoros\routing\MiddlewareDispatcher;
use Isoros\routing\Response;
use Isoros\routing\Session;
use Isoros\seeders\ExamSeeder;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionException;

class App
{
    private Container $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @throws NotFoundExceptionInterface
     * @throws ReflectionException
     * @throws ContainerExceptionInterface
     */
    public function run(): void
    {

        // Haal de Request, Response en Router objecten uit de container
        $request = $this->container->get(Request::class);
        $response = new Response();
        $router = $this->container->get(Router::class);

        // Voeg de Middleware objecten toe aan de MiddlewareDispatcher
        $middlewareDispatcher = MiddlewareDispatcher::fromContainer($this->container);
        // ...

        // Dispatch de request en krijg de response terug
        $middlewareDispatcher->process($request, $router, $response);

    }
}
