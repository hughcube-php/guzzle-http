<?php
/**
 * Created by PhpStorm.
 * User: hugh.li
 * Date: 2024/1/20
 * Time: 22:15.
 */

namespace HughCube\GuzzleHttp\Middleware;

use Closure;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\RequestInterface;

class AutoSkipVerifyMiddleware
{
    public static function middleware(callable $handler): Closure
    {
        return function (RequestInterface $request, array $options) use ($handler) {
            /** When you forcibly change the host using HTTPS, HTTPS authentication must be disabled. */
            if ('https' === $request->getUri()->getScheme()
                && $request->getUri()->getHost() !== $request->getHeaderLine('Host')
            ) {
                $options[RequestOptions::VERIFY] = false;
            }

            return $handler($request, $options);
        };
    }
}
