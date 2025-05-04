<?php
/**
 * Created by PhpStorm.
 * User: hugh.li
 * Date: 2022/3/7
 * Time: 19:34.
 */

namespace HughCube\GuzzleHttp;

class Once
{
    private static $defaultHttpClient = null;

    public static function getDefaultHttpClient(): Client
    {
        if (!self::$defaultHttpClient instanceof Client) {
            self::$defaultHttpClient = new Client();
        }

        return self::$defaultHttpClient;
    }
}
