<?php

declare(strict_types=1);

namespace Core\Request;

class CliRequest implements RequestHandlerInterface
{
    public static function create()
    {
        return [
            'filePath1' => $_SERVER['argv'][1],
            'filePath2' => $_SERVER['argv'][2]
        ];
    }
}