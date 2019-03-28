<?php

declare(strict_types=1);

require_once('./autoload.php');

use Core\Kernel;
use Core\Request;
use Core\Response;
use Core\Cache;

$request = Request::create();
if (Cache::isCached($request)) {
    return;
}
$response = Kernel::handleRequest($request);
$sent = Response::send($response);
Cache::saveInCache($request, $sent);

