<?php

declare(strict_types=1);

namespace Core\Request;

class JsonHttpRequest implements RequestHandlerInterface
{
    public static function create()
    {
        $json = file_get_contents('php://input');
        $data = (array) json_decode($json);
        return $data;
    }
}