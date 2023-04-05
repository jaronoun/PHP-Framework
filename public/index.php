<?php

require_once __DIR__ . '/..//vendor/autoload.php';// Autoload classes

use Isoros\Routing\Router; // Import Router class from Project\App namespace
use Isoros\Routing\Middleware;

// Create Router instance
$router = new Router();
$router->registerMiddleware(new Middleware());

// Define routes
$router->get('/', 'HomeController@index');
$router->get('/about', 'HomeController@about');
$router->get('/contact', 'HomeController@contact');

// Handle request
$response = $router->handle($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

// Output response
echo $response->getBody();