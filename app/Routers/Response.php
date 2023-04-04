<?php

namespace Isoros\Routers;

use Psr\Http\Message\StreamInterface;

require_once __DIR__ . '/../..//vendor/autoload.php';


Class Response implements ResponseInterface {
    // Hier kunnen eventuele extra methodes worden toegevoegd
    public function getProtocolVersion()
    {
        // TODO: Implement getProtocolVersion() method.
    }

    public function withProtocolVersion($version)
    {
        // TODO: Implement withProtocolVersion() method.
    }

    public function getHeaders() {
        return $this->headers;
    }

    public function hasHeader($name) {
        return isset($this->headers[$name]);
    }

    public function getHeader($name) {
        if (!$this->hasHeader($name)) {
            return [];
        }

        return $this->headers[$name];
    }

    public function getHeaderLine($name) {
        if (!$this->hasHeader($name)) {
            return '';
        }

        return implode(', ', $this->headers[$name]);
    }

    public function withHeader($name, $value) {
        $response = clone $this;
        $response->headers[$name] = (array) $value;

        return $response;
    }

    public function withAddedHeader($name, $value) {
        $response = clone $this;
        $response->headers[$name][] = $value;

        return $response;
    }

    public function withoutHeader($name) {
        $response = clone $this;
        unset($response->headers[$name]);

        return $response;
    }

    public function getBody() {
        return $this->body;
    }

    public function withBody(StreamInterface $body) {
        $response = clone $this;
        $response->body = $body;

        return $response;
    }

    public function getStatusCode() {
        return $this->statusCode;
    }

    public function withStatus($code, $reasonPhrase = '') {
        $response = clone $this;
        $response->statusCode = $code;

        if ($reasonPhrase === '' && isset(Response::$statusTexts[$code])) {
            $reasonPhrase = Response::$statusTexts[$code];
        }

        $response->reasonPhrase = $reasonPhrase;

        return $response;
    }

    public function getReasonPhrase() {
        return '';
    }
}