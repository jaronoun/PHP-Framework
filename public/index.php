<?php

// laad de autoloader
require_once __DIR__ . '/../vendor/autoload.php';
// Load the Router class
use Isoros\Core\App;

// Create App Instance
$app = new App();

$app->getRouter()->addRoute('GET', '/login', 'LoginController@index');
$app->getRouter()->addRoute('GET', '/login', 'LoginController@index');
$app->getRouter()->dispatch();

//$router->addRoute('GET', '/', 'HomeController@index');
//$router->addRoute('GET', '/users', 'UserController@index');
//$router->addRoute('GET', '/users/{id}', 'UserController@show');
//$router->addRoute('POST', '/users', 'UserController@store');
//$router->addRoute('PUT', '/users/{id}', 'UserController@update');
//$router->addRoute('DELETE', '/users/{id}', 'UserController@delete');

// Dispatch the request
