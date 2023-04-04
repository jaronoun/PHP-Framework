<?php

use Isoros\Core\Container;
use Isoros\Core\EventHandler;
use Isoros\Core\Router;
use Isoros\Middleware\AuthMiddleware;
use Isoros\Middleware\ThrottleMiddleware;

// Maak een instantie van de container
$container = new Container();

// Registreer de router en middleware in de container
$container->set('router', new Router());
$container->set('middleware', new MiddlewareStack([
new \Isoros\Controllers\Web\UserController(),
new \Isoros\Controllers\web\HomeController(),
]));

// Maak een instantie van de EventHandler en geef de router en middleware door
$eventHandler = new EventHandler($container->get('router'), $container->get('middleware'));

// Verwerk de request via de EventHandler en geef de response terug
$request = // haal de request op
$response = $eventHandler->handle($request);

// Stuur de response terug naar de client
$response->send();