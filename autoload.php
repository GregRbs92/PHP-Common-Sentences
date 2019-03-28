<?php

declare(strict_types=1);

function __autoload($path)
{
    $path = 'src/' . str_replace('\\', '/', $path) . '.php';
    $pathSegments = explode('/', $path);
    for ($i = 0; $i < count($pathSegments) - 1; $i++) { 
        $pathSegments[$i] = strtolower($pathSegments[$i]);
    }
    $path = implode('/', $pathSegments);
	require_once($path);
}
