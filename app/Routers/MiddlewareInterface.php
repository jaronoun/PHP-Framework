<?php
namespace Isoros\Routers;

require_once __DIR__ . '/../..//vendor/autoload.php';

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


interface MiddlewareInterface
{
    public function handle(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface;
}
