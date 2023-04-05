<?php

namespace Isoros\Http;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

class Request implements RequestInterface
{
    protected $method;
    protected $uri;
    protected $headers = [];
    protected $body;
    protected $protocolVersion;

    public function __construct($method, UriInterface $uri, $headers = [], StreamInterface $body = null, $protocolVersion = '1.1')
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->headers = $headers;
        $this->body = $body;
        $this->protocolVersion = $protocolVersion;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getHeader($name)
    {
        return $this->headers[$name] ?? [];
    }

    public function hasHeader($name)
    {
        return isset($this->headers[$name]);
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getRequestTarget()
    {
        $path = $this->uri->getPath();
        $query = $this->uri->getQuery();

        if ($query !== '') {
            $path .= '?' . $query;
        }

        $fragment = $this->uri->getFragment();

        if ($fragment !== '') {
            $path .= '#' . $fragment;
        }

        return $path;

            }
    public function withRequestTarget($requestTarget)
    {
        $new = clone $this;
        $newUri = $this->uri->withPath($requestTarget);
        if (strpos($requestTarget, '?') !== false) {
            list($path, $query) = explode('?', $requestTarget, 2);
            $newUri = $newUri->withPath($path)->withQuery($query);
        }
        return $new;
    }

    public function withMethod($method)
    {
        $new = clone $this;
        $new->method = $method;
        return $new;
    }

    public function withUri(UriInterface $uri, $preserveHost = false)
    {
        $new = clone $this;
        $new->uri = $uri;
        if (!$preserveHost || !$this->hasHeader('Host')) {
            $new->updateHostHeaderFromUri();
        }
        return $new;
    }

    public function withAddedHeader($name, $value)
    {
        $new = clone $this;
        $new->headers[$name][] = $value;
        return $new;
    }

    public function withHeader($name, $value)
    {
        $new = clone $this;
        $new->headers[$name] = is_array($value) ? $value : [$value];
        return $new;
    }

    public function withoutHeader($name)
    {
        $new = clone $this;
        unset($new->headers[$name]);
        return $new;
    }

    public function withBody(StreamInterface $body)
    {
        $new = clone $this;
        $new->body = $body;
        return $new;
    }

    public function getProtocolVersion()
    {
        return $this->protocolVersion;
    }

    public function withProtocolVersion($version)
    {
        $new = clone $this;
        $new->protocolVersion = $version;
        return $new;
    }

    private function updateHostHeaderFromUri()
    {
        $host = $this->uri->getHost();
        if (!empty($host)) {
            $port = $this->uri->getPort();
            if ($port !== null) {
                $host .= ':' . $port;
            }
            $this->headers['Host'] = [$host];
        }
    }
}
