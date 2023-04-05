<?php

namespace Isoros\Routers;

class UploadedFile
{
    protected $file;
    protected $size;
    protected $error;
    protected $clientFilename;
    protected $clientMediaType;

    public function __construct($file, $size, $error, $clientFilename = null, $clientMediaType = null)
    {
        $this->file = $file;
        $this->size = $size;
        $this->error = $error;
        $this->clientFilename = $clientFilename;
        $this->clientMediaType = $clientMediaType;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function getError()
    {
        return $this->error;
    }

    public function getClientFilename()
    {
        return $this->clientFilename;
    }

    public function getClientMediaType()
    {
        return $this->clientMediaType;
    }
}
