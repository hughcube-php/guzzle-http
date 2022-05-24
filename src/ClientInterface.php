<?php
/**
 * Created by PhpStorm.
 * User: hugh.li
 * Date: 2022/5/24
 * Time: 11:33
 */

namespace HughCube\GuzzleHttp;

use Psr\Http\Client\ClientInterface as PsrClientInterface;

if (class_exists(PsrClientInterface::class)) {
    interface ClientInterface extends PsrClientInterface
    {
    }
} else {
    interface ClientInterface
    {
    }
}
