<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Isoros\controllers\api\ExamRepository;
use Isoros\controllers\api\ExamUserRepository;
use Isoros\controllers\api\GradeRepository;
use Isoros\controllers\api\UserRepository;
use Isoros\core\App;
use Isoros\core\Container;
use Isoros\core\View;
use Isoros\routing\Request;
use Isoros\routing\Response;
use Isoros\routing\Router;
use Isoros\routing\Session;


$container = new Container();
$container->bind(View::class, function () {
    return new View(dirname(__DIR__) . '\app\views');
});
$container->bind(Request::class,function (){
    return Request::fromGlobals();
});
$container->bind(Response::class,Response::class);
$container->bind(Session::class,Session::class);
$container->bind(UserRepository::class, UserRepository::class);
$container->bind(GradeRepository::class, GradeRepository::class);
$container->bind(examRepository::class, ExamRepository::class);
$container->bind(ExamUserRepository::class, ExamUserRepository::class);
$container->bind(Router::class, function ($container) {
    $router = new Router($container);

    // Define routes
    //LOGIN
    $router->addRoute('GET', '/login', 'LoginController@index');
    $router->addRoute('POST', '/login', 'LoginController@handleLogin');

    $router->addRoute('GET', '/logout', 'LoginController@handleLogout');

    $router->addRoute('GET', '/register', 'RegisterController@index');
    $router->addRoute('POST', '/register', 'RegisterController@handleRegister');

    $router->addRoute('GET', '/cijfers', 'GradeController@show');
    $router->addRoute('GET', '/beoordeling', 'GradeController@showGrading');
    $router->addRoute('GET', '/tentamens', 'ExamController@index');
    $router->addRoute('POST', '/tentamens', 'ExamController@show');
    $router->addRoute('GET', '/profiel', 'UserController@index');

    $router->addRoute('GET', '/users', 'UserRepository@index');
    $router->addRoute('GET', '/users/{id}', 'UserRepository@show');
    $router->addRoute('POST', '/users', 'UserRepository@store');
    $router->addRoute('PUT', '/users/{id}', 'UserRepository@update');
    $router->addRoute('DELETE', '/users/{id}', 'UserRepository@delete');

    //REGISTER

    return $router;
});

$app = new App($container);
$app->run();



