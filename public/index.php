<?php

require_once 'vendor/autoload.php'; // Autoload classes

use Project\App\Router; // Import Router class from Project\App namespace

// Create Router instance
$router = new Router();

// Define routes
$router->get('/', 'HomeController@index');
$router->get('/about', 'HomeController@about');
$router->get('/contact', 'HomeController@contact');

// Handle request
$response = $router->handle($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

// Output response
echo $response->getBody();