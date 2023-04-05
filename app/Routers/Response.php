<?php

namespace Isoros\Routers\Request;

use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

class Request implements RequestInterface
{
    protected $method;
    protected $uri;
    protected $headers = [];
    protected $body;

    public function __construct(string $method, UriInterface $uri)
    {
        $this->method = $method;
        $this->uri = $uri;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUri(): UriInterface
    {
        return $this->uri;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getBody()
    {
        return $this->body;
    }

    // implementeer de andere methoden van de RequestInterface

    /**
     * @return string
     */
    public function getProtocolVersion(): string
    {
        return '1.1';
    }

    /**
     * @param string $version
     * @return MessageInterface|$this
     */
    public function withProtocolVersion(string $version): MessageInterface
    {
        $new = clone $this;
        $new->headers = $this->headers;
        $new->body = $this->body;
        $new->uri = $this->uri;
        $new->method = $this->method;
        return $new;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasHeader(string $name): bool
    {
        return isset($this->headers[strtolower($name)]);
    }

    /**
     * @param string $name
     * @return string[]
     */
    public function getHeader(string $name): array
    {
        if (!$this->hasHeader($name)) {
            return [];
        }

        $header = $this->headers[strtolower($name)];
        if (is_array($header)) {
            return $header;
        }

        return [$header];
    }

    /**
     * @param string $name
     * @return string
     */
    public function getHeaderLine(string $name): string
    {
        if (!$this->hasHeader($name)) {
            return '';
        }

        return implode(',', $this->getHeader($name));
    }

    /**
     * @param string $name
     * @param $value
     * @return MessageInterface|$this
     */
    public function withHeader(string $name, $value): MessageInterface
    {
        $new = clone $this;
        $new->headers[strtolower($name)] = $value;
        return $new;
    }

    /**
     * @param string $name
     * @param $value
     * @return MessageInterface|$this
     */
    public function withAddedHeader(string $name, $value): MessageInterface
    {
        $new = clone $this;
        if ($this->hasHeader($name)) {
            $new->headers[strtolower($name)] = array_merge($this->headers[strtolower($name)], (array)$value);
        } else {
            $new->headers[strtolower($name)] = (array)$value;
        }
        return $new;
    }

    /**
     * @param string $name
     * @return MessageInterface|$this
     */
    public function withoutHeader(string $name): MessageInterface
    {
        if (!$this->hasHeader($name)) {
            return $this;
        }

        $message = clone $this;
        unset($message->headers[$name]);
        return $message;
    }

    /**
     * @param StreamInterface $body
     * @return MessageInterface|$this
     */
    public function withBody(StreamInterface $body): MessageInterface
    {
        $message = clone $this;
        $message->body = $body;
        return $message;
    }

    /**
     * @return string
     */
    public function getRequestTarget(): string
    {
        $target = $this->uri->getPath();
        if ($query = $this->uri->getQuery()) {
            $target .= '?' . $query;
        }

        return empty($target) ? '/' : $target;
    }

    /**
     * @param string $requestTarget
     * @return RequestInterface|$this
     */
    public function withRequestTarget(string $requestTarget): RequestInterface
    {
        $uri = $this->uri->withPath($requestTarget);
        $message = clone $this;
        $message->uri = $uri;
        return $message;
    }

    /**
     * @param string $method
     * @return RequestInterface|$this
     */
    public function withMethod(string $method): RequestInterface
    {
        $message = clone $this;
        $message->method = $method;
        return $message;
    }

    /**
     * @param UriInterface $uri
     * @param bool $preserveHost
     * @return RequestInterface|$this
     */
    public function withUri(UriInterface $uri, bool $preserveHost = false): RequestInterface
    {
        $message = clone $this;
        $message->uri = $uri;

        if (!$preserveHost || !isset($this->headers['Host'])) {
            $host = $uri->getHost();

            if ($port = $uri->getPort()) {
                $host .= ':' . $port;
            }

            $message = $message->withHeader('Host', $host);
        }

        return $message;
    }

}