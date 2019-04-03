<?php

declare(strict_types=1);

namespace Core;

use Core\Request\CliRequest;
use Core\Request\HttpRequest;
use Core\Request\JsonHttpRequest;

class Request
{
    public static function create()
    {
        // Get the request data from the command line
        if (php_sapi_name() == "cli") {
            return CliRequest::create();
        }
        // Get the request data sent over http
        else {
            return self::handleHttpRequest();
        }
    }

    private static function handleHttpRequest()
    {
        // Get request's content type
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        switch ($contentType) {
        case 'application/json':
            return JsonHttpRequest::create();
        default:
            return HttpRequest::create();
        }
    }
}