<?php

use Isoros\Core\Container;
use Isoros\Core\EventHandler;
use Isoros\Controllers\web\HomeController;
use Isoros\Controllers\web\UserController;

class Router {
    private $container;
    private $eventHandler;

    public function __construct(Container $container, EventHandler $eventHandler) {
        $this->container = $container;
        $this->eventHandler = $eventHandler;
    }

    public function defineRoutes() {
        $this->eventHandler->addMiddleware(function ($request, $next) {
            // voeg hier eventueel middleware toe voor alle routes
            return $next($request);
        });

        $this->eventHandler->get('/', [HomeController::class, 'index']);

        $this->eventHandler->get('/users', [UserController::class, 'index']);
        $this->eventHandler->post('/users', [UserController::class, 'create']);

        $this->eventHandler->get('/users/{id:\d+}', [UserController::class, 'show']);
        $this->eventHandler->put('/users/{id:\d+}', [UserController::class, 'update']);
        $this->eventHandler->delete('/users/{id:\d+}', [UserController::class, 'delete']);

        // voeg hier meer routes toe
    }
}