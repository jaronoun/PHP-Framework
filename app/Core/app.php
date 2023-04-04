<?php

require_once '../vendor/autoload.php';
require_once '../Isoros/Routers/Router.php';
require_once '../Isoros/Routers/Route.php';
require_once '../Isoros/Routers/RouteCollection.php';
require_once '../Isoros/Middleware/MiddlewareInterface.php';
require_once '../Isoros/Middleware/BaseMiddleware.php';
require_once '../Isoros/Middleware/MiddlewareCollection.php';
require_once '../app/Http/Request.php';
require_once '../app/Http/Response.php';
require_once '../app/Http/StatusCode.php';

use Isoros\Routers\Router;
use Isoros\Routers\Route;
use Isoros\Routers\RouteCollection;
use Isoros\Routers\MiddlewareCollection;
use Isoros\Routers\Request;
use Isoros\Routers\Response;
use Isoros\Routers\StatusCode;

$request = Request::createFromGlobals();
$response = new Response();

$routeCollection = new RouteCollection();
$routeCollection->add(new Route('/', 'IndexController@index', 'GET'));

$middlewareCollection = new MiddlewareCollection();
$middlewareCollection->add(function(Request $request, Response $response, $next) {
    $response->setContent('Middleware 1 executed!');
    $response->setStatusCode(StatusCode::OK);
    return $next($request, $response);
});
$middlewareCollection->add(function(Request $request, Response $response, $next) {
    $response->setContent('Middleware 2 executed!');
    $response->setStatusCode(StatusCode::OK);
    return $next($request, $response);
});

$router = new Router($routeCollection, $middlewareCollection);
$route = $router->match($request);
if ($route) {
    $response = call_user_func_array($route->getCallable(), [$request, $response]);
} else {
    $response->setStatusCode(StatusCode::NOT_FOUND);
}

$response->send();