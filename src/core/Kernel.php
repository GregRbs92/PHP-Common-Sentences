<?php

declare(strict_types=1);

namespace Core;

use Controllers\HomeController;

class Kernel
{
    public static function handleRequest($request)
    {
        $controller = new HomeController();
        return $controller->compute($request);
    }
}