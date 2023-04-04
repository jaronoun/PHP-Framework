<?php

namespace Isoros\Routers;


use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;

require_once __DIR__ . '/../..//vendor/autoload.php';

class ServerRequestFactory implements ServerRequestFactoryInterface
{
    public function createServerRequest(string $method, $uri, array $serverParams = []): ServerRequestInterface
    {
        $headers = getallheaders();
        $body = file_get_contents('php://input');

        $serverRequest = new ServerRequest($method, $uri, $headers, $body);

        return $serverRequest;

    }

    public static function createFromGlobals(): ServerRequest
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $headers = getallheaders();
        $body = file_get_contents('php://input');

        return new ServerRequest($method, $uri, $headers, $body);
    }
}
