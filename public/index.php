<?php

// laad de autoloader
require_once __DIR__ . '/../vendor/autoload.php';
// Load the Router class
require_once __DIR__ . '/../app/Routers/router.php';
$router = new Router();

// Define routes
$router->addRoute('GET', '/', function () {
    echo 'Home page';
});

$router->addRoute('GET', '/users', function () {
    // Handle user index page
});

$router->addRoute('GET', '/users/{id}', function ($params) {
    // Handle user show page
});

// Dispatch the current request
$router->dispatch();