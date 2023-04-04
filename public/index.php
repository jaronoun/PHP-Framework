
<?php

use Isoros\Core\App;
use Isoros\Core\Container;
use Isoros\Routers\Router;
use Isoros\Controllers\Web\HomeController;
use Isoros\Database\MySQLConnection;
use Isoros\Repositories\UserRepository;
use Isoros\Services\UserService;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

require __DIR__ . '/../vendor/autoload.php';

// Create PSR-7 factories
$container = new Container();
$container->set(ServerRequestFactoryInterface::class, function () {
    return \Slim\Psr7\Factory\ServerRequestFactory::createFromGlobals();
});
$container->set(ResponseFactoryInterface::class, function () {
    return new \Slim\Psr7\Factory\ResponseFactory();
});
$container->set(StreamFactoryInterface::class, function () {
    return new \Slim\Psr7\Factory\StreamFactory();
});
$container->set(UriFactoryInterface::class, function () {
    return new \Slim\Psr7\Factory\UriFactory();
});

// Create database connection
$container->set(MySQLConnection::class, function ($container) {
    $config = $container->get('config')['database'];
    return new MySQLConnection($config['host'], $config['database'], $config['username'], $config['password']);
});

// Create repositories
$container->set(UserRepository::class, function ($container) {
    return new UserRepository($container->get(MySQLConnection::class));
});

// Create services
$container->set(UserService::class, function ($container) {
    return new UserService($container->get(UserRepository::class));
});

// Create views
//$twig = Twig::create(__DIR__ . '/../resources/views', ['cache' => false]);
//$container->set(Twig::class, $twig);

// Create controllers
$container->set(HomeController::class, function ($container) {
    return new HomeController($container->get(UserService::class), $container->get(Twig::class));
});

// Create router
$router = new Router($container);
$router->get('/', HomeController::class . ':index');

// Create app
$app = AppFactory::create();
$app->add(TwigMiddleware::createFromContainer($app));
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);
$app->setBasePath('/');

// Run app
$app->run();