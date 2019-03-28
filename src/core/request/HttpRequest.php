<?php

declare(strict_types=1);

namespace Core\Request;

class HttpRequest implements RequestHandlerInterface
{
    public static function create()
    {
        return array_merge($_GET, $_POST);
    }
}