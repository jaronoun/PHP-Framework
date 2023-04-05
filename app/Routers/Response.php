<?php

namespace Isoros\Http;

use Psr\Http\Message\ResponseInterface;

class Response implements ResponseInterface
{
    protected $statusCode;
    protected $headers = [];
    protected $body;

    public function __construct($body = '', $statusCode = 200, $headers = [])
    {
        $this->body = $body;
        $this->statusCode = $statusCode;
        $this->headers = $headers;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getReasonPhrase()
    {
        // Not implemented
    }

    public function getProtocolVersion()
    {
        // Not implemented
    }

    public function withStatus($code, $reasonPhrase = '')
    {
        $new = clone $this;
        $new->statusCode = $code;

        return $new;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getHeader($name)
    {
        return $this->headers[$name] ?? [];
    }

    public function getBody()
    {
        return $this->body;
    }

    public function withHeader($name, $value)
    {
        $new = clone $this;
        $new->headers[$name] = [$value];

        return $new;
    }

    public function withAddedHeader($name, $value)
    {
        $new = clone $this;
        $new->headers[$name][] = $value;

        return $new;
    }

    public function withBody(\Psr\Http\Message\StreamInterface $body)
    {
        $new = clone $this;
        $new->body = $body;

        return $new;
    }

    public function withoutHeader($name)
    {
        $new = clone $this;
        unset($new->headers[$name]);

        return $new;
    }

    public function withProtocolVersion($version)
    {
        // TODO: Implement withProtocolVersion() method.
    }

    public function hasHeader($name)
    {
        // TODO: Implement hasHeader() method.
    }

    public function getHeaderLine($name)
    {
        // TODO: Implement getHeaderLine() method.
    }
}
