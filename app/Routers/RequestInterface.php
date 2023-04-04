<?php

namespace Isoros\Routers;

require_once __DIR__ . '/../..//vendor/autoload.php';

interface RequestInterface extends \Psr\Http\Message\RequestInterface {
    // Hier kunnen eventuele extra methodes worden toegevoegd
}