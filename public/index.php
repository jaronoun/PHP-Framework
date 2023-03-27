<?php

// laad de autoloader
require_once __DIR__ . '/../vendor/autoload.php';
// Load the Router class
require_once __DIR__ . '/../app/Routers/router.php';
$router = new Router();

// Define routes
$router->addRoute('GET', '/', 'UserController@index');

$router->addRoute('GET', '/users', 'UserController@index');

$router->addRoute('GET', '/users/{id}','UserController@show');

// Dispatch the current request
$router->dispatch();