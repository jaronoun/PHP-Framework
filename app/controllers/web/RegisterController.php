<?php
namespace Isoros\controllers\web;

use Isoros\core\controller;
use Isoros\core\View;
use Isoros\routing\Request;
use Isoros\controllers\api\UserController;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

require_once __DIR__ . '/../../../vendor/autoload.php';



class RegisterController extends Controller
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index()
        {
            $title = "Register";
            $container = $this->getContainer();
            $view = $container->get(View::class);
            $view->render('auth/register');
        }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function handleRegister()
    {
        $request = $this->getContainer()->get(Request::class);
        $userRepository = $this->getContainer()->get(UserController::class);
//        $user = $userRepository->createUser($request->getParams()["name"], $request->getParams()["email"], $request->getParams()["password"], $request->getParams()["role"]);

//        echo "$user";

    }
}