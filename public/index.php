<?php

use Isoros\core\Container;
use Isoros\core\Controller;
use Isoros\Routers\Request;
use Isoros\Routers\Router;
use Isoros\Routers\MiddlewareDispatcher;
use Isoros\Routers\Response;

// Laad de autoload file in
require_once __DIR__ . '/../vendor/autoload.php';

// Initialiseer de container
$container = new Container();

// Voeg de Request en Response objects toe aan de container
$container->set(Request::class, function () {
    return Request::fromGlobals();
});

$container->set(Response::class, function () {
    return new Response();
});

// Maak de HomeController en geef de container door
$controller = new Controller($container);


// Voeg de Router object toe aan de container
$container->set(Router::class, function () {
    $router = new Router();

    // Define routes
    $router->addRoute('GET', '/', 'HomeController@index');
    $router->addRoute('POST', '/', 'HomeController@index');
    $router->addRoute('GET', '/users', 'UserController@index');
    $router->addRoute('GET', '/users/{id}', 'UserController@show');
    $router->addRoute('POST', '/users', 'UserController@store');
    $router->addRoute('PUT', '/users/{id}', 'UserController@update');
    $router->addRoute('DELETE', '/users/{id}', 'UserController@delete');

    return $router;
});

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
$response = $container->get(Response::class);
$router = $container->get(Router::class);

// Dispatch de request en krijg de response terug
$response = $middlewareDispatcher->process($request, $router);

