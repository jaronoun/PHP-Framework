<?php

namespace Isoros\routing;

use Psr\Http\Message\UriInterface;

class Uri implements UriInterface
{
    protected $scheme;
    protected $userInfo;
    protected $host;
    protected $port;
    protected $path;
    protected $query;
    protected $fragment;

    public function __construct($scheme, $userInfo, $host, $port, $path, $query, $fragment)
    {
        $this->scheme = $scheme;
        $this->userInfo = $userInfo;
        $this->host = $host;
        $this->port = $port;
        $this->path = $path;
        $this->query = $query;
        $this->fragment = $fragment;
    }

    public function getScheme()
    {
        return $this->scheme;
    }

    public function getAuthority()
    {
        $authority = '';
        if (!empty($this->userInfo)) {
            $authority .= $this->userInfo . '@';
        }
        if (!empty($this->host)) {
            $authority .= $this->host;
        }
        if (!empty($this->port)) {
            $authority .= ':' . $this->port;
        }
        return $authority;
    }

    public function getUserInfo()
    {
        return $this->userInfo;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getPort()
    {
        return $this->port;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function getFragment()
    {
        return $this->fragment;
    }

    public function withScheme($scheme)
    {
        $new = clone $this;
        $new->scheme = $scheme;
        return $new;
    }

    public function withUserInfo($user, $password = null)
    {
        $new = clone $this;
        $new->userInfo = $user;
        if ($password !== null) {
            $new->userInfo .= ':' . $password;
        }
        return $new;
    }

    public function withHost($host)
    {
        $new = clone $this;
        $new->host = $host;
        return $new;
    }

    public function withPort($port)
    {
        $new = clone $this;
        $new->port = $port;
        return $new;
    }

    public function withPath($path)
    {
        $new = clone $this;
        $new->path = $path;
        return $new;
    }

    public function withQuery($query)
    {
        $new = clone $this;
        $new->query = $query;
        return $new;
    }

    public function withFragment($fragment)
    {
        $new = clone $this;
        $new->fragment = $fragment;
        return $new;
    }

    public function __toString()
    {
        $uri = '';
        if (!empty($this->scheme)) {
            $uri .= $this->scheme . ':';
        }
        $uri .= '//' . $this->getAuthority();
        if (!empty($this->path)) {
            $uri .= $this->path;
        }
        if (!empty($this->query)) {
            $uri .= '?' . $this->query;
        }
        if (!empty($this->fragment)) {
            $uri .= '#' . $this->fragment;
        }
    }
}
