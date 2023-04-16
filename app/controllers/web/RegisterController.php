<?php
namespace Isoros\controllers\web;

use Isoros\core\controller;
use Isoros\core\View;
use Isoros\routing\Request;
use Isoros\controllers\api\UserRepository;
use Isoros\routing\Session;
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
        $container = $this->getContainer();
        $view = $container->get(View::class);
        $request = $container->get(Request::class);

        $userRepository = $container->get(UserRepository::class);
        $user = $userRepository->createUser(
                          $request->getParams()["name"],
                          $request->getParams()["email"],
                          password_hash($request->getParams()["password"], PASSWORD_DEFAULT),
                          $request->getParams()["role"]);

        if(!$user){
            echo "Er is iets fout gegaan";
            $view->render('auth/register');

        } else {
            $session = $this->getContainer()->get(Session::class);
            $session->set('user', $request->getParams()["email"]);
            $session->set('loggedIn', true);


            header('Location: /cijfers');
            exit;
        }

    }
}