<?php
/**
 * Created by PhpStorm.
 * User: hugh.li
 * Date: 2024/1/20
 * Time: 22:15
 */

namespace HughCube\GuzzleHttp\Middleware;

use Closure;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\RequestInterface;

class UseHostResolveMiddleware
{
    public static function middleware(callable $handler): Closure
    {
        return function (RequestInterface $request, array $options) use ($handler) {

            if (!$request->hasHeader('Host')) {
                $request = $request->withHeader('Host', $request->getUri()->getHost());
            }

            if (!empty($ip = $options['extra']['host_resolve'][$request->getUri()->getHost()] ?? null)) {
                $request = $request->withUri($request->getUri()->withHost($ip), true);
            }

            if ('https' === $request->getUri()->getScheme()
                && $request->getUri()->getHost() !== $request->getHeaderLine('Host')
            ) {
                $options[RequestOptions::VERIFY] = false;
            }

            return $handler($request, $options);
        };
    }

    public static function parseConfig(string $string): array
    {
        $map = [];
        foreach (explode(',', $string) as $item) {
            if (preg_match('/^([^:]+):([^:]+)$/', $item, $match)) {
                $map[$match[1]] = $match[2];
            }
        }
        return $map;
    }
}
