<?php

declare(strict_types=1);

namespace Core\Request;

class CliRequest implements RequestHandlerInterface
{
    public static function create()
    {
        return [
            'firstFile' => $_SERVER['argv'][1],
            'secondFile' => $_SERVER['argv'][2]
        ];
    }
}