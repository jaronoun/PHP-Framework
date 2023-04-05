<?php

namespace Isoros\Core;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Isoros\Routing\Router;

class app
{
    private $container;
    private $router;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->router = new Router();
    }

    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    public function getRouter(): Router
    {
        return $this->router;
    }

    public function run()
    {
        try {
            $request = $this->container->get(Request::class);
            $response = $this->router->handle($request);
            $this->respond($response);
        } catch (\Exception $e) {
            $this->handleException($e);
        }
    }

    private function respond(Response $response)
    {
        // Set response headers
        foreach ($response->getHeaders() as $name => $values) {
            foreach ($values as $value) {
                header(sprintf('%s: %s', $name, $value), false);
            }
        }

        // Set response body
        echo $response->getBody();
    }

    private function handleException(\Exception $e)
    {
        // Handle exceptions and generate error response
        http_response_code($e->getCode());
        echo 'Error: ' . $e->getMessage();
    }
}