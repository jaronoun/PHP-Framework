<?php

function url($controller = null, $action = null)
{
    $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/';

    if ($controller !== null) {
        $url .= $controller;

        if ($action !== null) {
            $url .= '/' . $action;
        }
    }

    return $url;
}

