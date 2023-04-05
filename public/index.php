<?php

require_once __DIR__ . '/..//vendor/autoload.php';// Autoload classes

$router = new Routing\Router();

// Definieer routes
$router->addRoute('GET', '/', function () {
    echo 'Welkom bij mijn website!';
});

$router->addRoute('GET', '/about', function () {
    echo 'Dit is de "over ons" pagina.';
});

$router->addRoute('GET', '/contact', function () {
    echo 'Dit is de "contact" pagina.';
});

// Match de huidige request
$match = $router->matchCurrentRequest();

// Voer de callback-functie uit als er een match is
if ($match) {
    call_user_func_array($match['target'], $match['params']);
} else {
    echo '404 Pagina niet gevonden';
}