<?php

declare(strict_types=1);

namespace Core;

class Response
{
    public static function send($response)
    {
        header('Content-Type: application/json');
        echo $response;
        return $response;
    } 
}