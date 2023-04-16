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
        $path = $request->getUri()->getPath();


        if ($path === '/login' || $path === '/register') {
            return $handler->handle($request);
        } else {
            if (!$this->session->get('user')) {
                header('Location: /login');
                exit;
            }
        }

        if ($this->next instanceof MiddlewareInterface) {
            return $this->next->process($request, $handler);
        }

        return $handler->handle($request);
    }
}
