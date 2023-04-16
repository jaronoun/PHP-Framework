<?php
namespace Isoros\routing;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class Middleware implements MiddlewareInterface
{
    protected $next;
    protected Session $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function setNext(MiddlewareInterface $next): void
    {
        $this->next = $next;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // Code voor het verwerken van de request
        // Authentication
        // Create a new Session object


        $path = $request->getUri()->getPath();
        if ($path === '/login' || $path === '/register') {
            // Skip authentication check
            return $handler->handle($request);
        } else {
            if (!$this->session->get('user')) {
                echo "hoi";
                // If 'user_id' session variable is not set,
                // redirect to the login page
                header('Location: /login');
                exit;
            }
        }

        // Keten de volgende middleware aan de huidige middleware
        if ($this->next instanceof MiddlewareInterface) {
            return $this->next->process($request, $handler);
        }

        // Als er geen volgende middleware is, stuur dan de response terug
        return $handler->handle($request);
    }
}
