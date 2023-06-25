<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Isoros\controllers\api\ExamRepository;
use Isoros\controllers\api\ExamUserRepository;
use Isoros\controllers\api\GradeRepository;
use Isoros\controllers\api\UserRepository;
use Isoros\core\App;
use Isoros\core\Container;
use Isoros\core\Model;
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
$container->bind(Model::class, Model::class);
$container->bind(Router::class, function ($container) {
    $router = new Router($container);

    // Define routes
    //LOGIN
    $router->addRoute('GET', '/', 'LoginController@index');
    $router->addRoute('GET', '/login', 'LoginController@index');
    $router->addRoute('POST', '/login', 'LoginController@handleLogin');

    $router->addRoute('GET', '/logout', 'LoginController@handleLogout');

    $router->addRoute('GET', '/register', 'RegisterController@index');
    $router->addRoute('POST', '/register', 'RegisterController@handleRegister');

    $router->addRoute('GET', '/cijfers', 'GradeController@show');

    $router->addRoute('GET', '/beoordeling', 'GradeController@showExams');
    $router->addRoute('GET', '/beoordeling/{id}', 'GradeController@showExamUsers');
    $router->addRoute('POST', '/beoordeling/{examID}/{userID}', 'GradeController@storeGrade');
    $router->addRoute('GET', '/beoordeling/{examID}/{userID}', 'GradeController@deleteGrade');

    $router->addRoute('POST', '/tentamens/cijfer', 'ExamController@storeGrade');
    $router->addRoute('GET', '/tentamens/cijfer/{gradeID}', 'ExamController@removeGrade');
    $router->addRoute('POST', '/tentamens/cijfer/{gradeID}', 'ExamController@updateGrade');

    $router->addRoute('GET', '/tentamens', 'ExamController@index');
    $router->addRoute('POST', '/tentamens', 'ExamController@storeExam');
    $router->addRoute('POST', '/tentamens/maken', 'ExamController@makeExam');
    $router->addRoute('GET', '/tentamens/{id}', 'ExamController@removeExam');
    $router->addRoute('GET', '/tentamens/enroll/{id}', 'ExamController@enrollExam');
    $router->addRoute('GET', '/tentamens/unEnroll/{id}', 'ExamController@unEnrollExam');
    $router->addRoute('POST', '/tentamens/{examID}', 'ExamController@updateExam');



    $router->addRoute('GET', '/profiel', 'UserController@index');

    $router->addRoute('GET', '/users', 'UserController@index');
    $router->addRoute('POST', '/users/enroll', 'UserController@enrollUser');
    $router->addRoute('POST', '/users', 'UserController@store');
    $router->addRoute('POST', '/users/{userID}', 'UserController@update');
    $router->addRoute('GET', '/users/{userID}', 'UserController@delete');
    $router->addRoute('GET', '/users/unenroll/{enrollID}', 'UserController@deleteEnrollment');


    //REGISTER

    return $router;
});

$app = new App($container);
$app->run();



