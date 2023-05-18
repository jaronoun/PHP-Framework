<?php

use Isoros\controllers\api\ExamRepository;
use Isoros\controllers\api\GradeRepository;
use Isoros\controllers\api\UserRepository;
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

// Laad de autoload file in
require_once __DIR__ . '/../vendor/autoload.php';

// Initialiseer de container
$container = new Container();

// Voeg de Request en Response objects toe aan de container

$container->set(UserRepository::class, function () {
    return new UserRepository();
});
$container->set(ExamRepository::class, function () {
    return new ExamRepository();
});
$container->set(GradeRepository::class, function () {
    return new GradeRepository();
});
$container->set(ExamUserRepository::class, function () {
    return new ExamUserRepository();
});
$container->set(Model::class, function () {
    return new Model();
});
// Voeg de Request en Response objects toe aan de container
$container->set(View::class, function () {
    return new View();
});
// Voeg de Request en Response objects toe aan de container
$container->set(Request::class, function () {
    return Request::fromGlobals();
});
$container->set(Response::class, function () {
    return new Response();
});

// Voeg de Request en Response objects toe aan de container
$container->set(Session::class, function () {
    return new Session();
});

// Maak de HomeController en geef de container door
// $controller = new Controller($container);


// Voeg de Router object toe aan de container
$container->set(Router::class, function () {
    $router = new Router();

    // Define routes
    //LOGIN
    $router->addRoute('GET', '/login', 'LoginController@index');
    $router->addRoute('POST', '/login', 'LoginController@handleLogin');

    $router->addRoute('GET', '/logout', 'LoginController@handleLogout');

    $router->addRoute('GET', '/register', 'RegisterController@index');
    $router->addRoute('POST', '/register', 'RegisterController@handleRegister');

    $router->addRoute('GET', '/cijfers', 'GradeController@show');
    $router->addRoute('GET', '/tentamens', 'ExamController@index');
    $router->addRoute('POST', '/tentamens', 'ExamController@show');
    $router->addRoute('GET', '/profiel', 'UserController@show');

    $router->addRoute('GET', '/users', 'UserRepository@index');
    $router->addRoute('GET', '/users/{id}', 'UserRepository@show');
    $router->addRoute('POST', '/users', 'UserRepository@store');
    $router->addRoute('PUT', '/users/{id}', 'UserRepository@update');
    $router->addRoute('DELETE', '/users/{id}', 'UserRepository@delete');

    //REGISTER

    return $router;
});

//(new ExamSeeder())->run();
//(new GradeSeeder())->run();

// Voeg de Middleware objecten toe aan de container
//$container->set('middleware.auth', function () {
//return new AuthMiddleware();
//});

//$container->set('middleware.log', function () {
//return new LogMiddleware();
//});

// Maak een nieuwe MiddlewareDispatcher object en voeg de middlewares toe
$middlewareDispatcher = MiddlewareDispatcher::fromContainer($container);
//$middlewareDispatcher->addMiddleware($container->get('middleware.auth'));
//$middlewareDispatcher->addMiddleware($container->get('middleware.log'));

// Haal de Request, Response en Router objecten uit de container
$request = $container->get(Request::class);
// $response = $container->get(Response::class);
$router = $container->get(Router::class);

// Dispatch de request en krijg de response terug
$middlewareDispatcher->process($request, $router);



