<?php

namespace Isoros\Http;

use Psr\Http\Message\StreamInterface;

class Stream implements StreamInterface
{
    protected $resource;
    protected $size;
    protected $seekable;
    protected $readable;
    protected $writable;

    public function __construct($stream)
    {
        $this->resource = fopen($stream, 'r+');
        $this->size = null;
        $this->seekable = true;
        $this->readable = true;
        $this->writable = true;
    }

    public function __toString()
    {
        try {
            $this->rewind();
            return $this->getContents();
        } catch (\Exception $e) {
            return '';
        }
    }

    public function close()
    {
        if (isset($this->resource)) {
            fclose($this->resource);
            $this->detach();
        }
    }

    public function detach()
    {
        $resource = $this->resource;
        unset($this->resource);
        $this->size = null;
        $this->seekable = false;
        $this->readable = false;
        $this->writable = false;
        return $resource;
    }

    public function getSize()
    {
        if (isset($this->size)) {
            return $this->size;
        }

        if (!isset($this->resource)) {
            return null;
        }

        $stats = fstat($this->resource);
        if (isset($stats['size'])) {
            $this->size = $stats['size'];
            return $this->size;
        }

        return null;
    }

    public function tell()
    {
        if (!isset($this->resource)) {
            throw new \RuntimeException('Stream is detached');
        }

        $position = ftell($this->resource);
        if ($position === false) {
            throw new \RuntimeException('Unable to determine stream position');
        }

        return $position;
    }

    public function eof()
    {
        if (!isset($this->resource)) {
            return true;
        }

        return feof($this->resource);
    }

    public function isSeekable()
    {
        return $this->seekable;
    }

    public function seek($offset, $whence = SEEK_SET)
    {
        if (!isset($this->resource)) {
            throw new \RuntimeException('Stream is detached');
        }

        if (!$this->seekable) {
            throw new \RuntimeException('Stream is not seekable');
        }

        if (fseek($this->resource, $offset, $whence) === -1) {
            throw new \RuntimeException('Unable to seek to stream position ' . $offset . ' with whence ' . var_export($whence, true));
        }
    }

    public function rewind()
    {
        $this->seek(0);
    }

    public function isWritable()
    {
        return $this->writable;
    }

    public function write($string)
    {
        if (!isset($this->resource)) {
            throw new \RuntimeException('Stream is detached');
        }

        if (!$this->writable) {
            throw new \RuntimeException('Cannot write to a non-writable stream');
        }

        $result = fwrite($this->resource, $string);
        if ($result === false) {
            throw new \RuntimeException('Unable to write to stream');
        }

        $this->size = null;

        return $result;
    }

    public function isReadable()
    {
        return $this->readable;
    }

    public function read($length)
    {
        if (!isset($this->resource)) {
            throw new \RuntimeException('Stream is detached');
        }

        if (!$this->readable) {
            throw new \RuntimeException('Cannot read from non-readable stream');
        }

        return fread($this->resource, $length);
    }

    public function getContents()
    {
        if (!isset($this->resource)) {
            throw new \RuntimeException('Stream is detached');
        }

        if (!$this->readable) {
            throw new \RuntimeException('Cannot read from non-readable stream');
        }

        $contents = stream_get_contents($this->resource);

        if ($contents === false) {
            throw new \RuntimeException('Unable to read stream contents');
        }

        return $contents;
    }

    public function getMetadata($key = null)
    {
        $meta = stream_get_meta_data($this->resource);

        if ($key === null) {
            return $meta;
        }

        return isset($meta[$key]) ? $meta[$key] : null;
    }
}
