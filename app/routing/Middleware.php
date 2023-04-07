<?php
namespace Isoros\routing;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class Middleware implements MiddlewareInterface
{
    protected $next;

    public function setNext(MiddlewareInterface $next): void
    {
        $this->next = $next;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // Code voor het verwerken van de request
        // Authentication
//        if (!isset($_SESSION['user'])) {
//            // zo niet, dan redirect naar de login pagina
//            return $response->withRedirect('/login');
//        }



        // Keten de volgende middleware aan de huidige middleware
        if ($this->next instanceof MiddlewareInterface) {
            return $this->next->process($request, $handler);
        }

        // Als er geen volgende middleware is, stuur dan de response terug
        return $handler->handle($request);
    }
}
