<?php
//
//// laad de autoloader
//require_once __DIR__ . '/../vendor/autoload.php';
//// Load the Router class
//use Isoros\Routers\Router;
//
//$router = new Router();
//
//// Define routes
//$router->addRoute('GET', '/', 'HomeController@index');
//$router->addRoute('GET', '/users', 'UserController@index');
//$router->addRoute('GET', '/users/{id}', 'UserController@show');
//$router->addRoute('POST', '/users', 'UserController@store');
//$router->addRoute('PUT', '/users/{id}', 'UserController@update');
//$router->addRoute('DELETE', '/users/{id}', 'UserController@delete');
//
//// Dispatch the request
//$router->dispatch();


use Isoros\Routers\Request;
use Isoros\Routers\Router;
use Isoros\Routers\MiddlewareDispatcher;
use Osiris\Routers\Response;

// Maak een nieuwe Request object
$request = Request::fromGlobals();

// Maak een nieuwe Response object
$response = new Response();

 //Maak een nieuwe Router object en voeg de routes toe
// laad de autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Load the Router class
$router = new Router();

// Define routes
$router->addRoute('GET', '/', 'HomeController@index');
$router->addRoute('GET', '/users', 'UserController@index');
$router->addRoute('GET', '/users/{id}', 'UserController@show');
$router->addRoute('POST', '/users', 'UserController@store');
$router->addRoute('PUT', '/users/{id}', 'UserController@update');
$router->addRoute('DELETE', '/users/{id}', 'UserController@delete');

// Dispatch the request
$router->dispatch();

$container = new Container();

// Maak een MiddlewareDispatcher object en voeg de middlewares toe
$middlewareDispatcher = MiddlewareDispatcher::fromContainer($container);

// Voer de middleware en router uit om de response te krijgen
$response = $middlewareDispatcher->process($request, $router);

// Stuur de response terug naar de client
$response->send();