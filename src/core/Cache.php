<?php

declare(strict_types=1);

namespace Core;

class Cache
{
    public static function isCached($request)
    {
        $fileName = self::generateFileName($request);
        $cache = __DIR__ . "/../../cache/$fileName.json";
        $expire = time() - 3600 ; // valable une heure
        
        if(file_exists($cache) && filemtime($cache) > $expire)
        {
            readfile($cache);
            return true;
        }

        return false;
    }

    public static function saveInCache($request, $response)
    {
        $fileName = self::generateFileName($request);
        file_put_contents(__DIR__ . "/../../cache/$fileName.json", $response);
    }

    private static function generateFileName($request)
    {
        $fileName = $_SERVER['REQUEST_URI'];
        foreach ($request as $key => $value) {
            $fileName = $fileName . $key . $value;
        }
        return base64_encode($fileName);
    }
}