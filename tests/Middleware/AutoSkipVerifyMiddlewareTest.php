<?php
/**
 * Created by PhpStorm.
 * User: hugh.li
 * Date: 2024/1/20
 * Time: 23:11.
 */

namespace HughCube\GuzzleHttp\Tests\Middleware;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\RequestOptions;
use HughCube\GuzzleHttp\Client;
use HughCube\GuzzleHttp\Middleware\AutoSkipVerifyMiddleware;
use HughCube\GuzzleHttp\Tests\TestCase;

class AutoSkipVerifyMiddlewareTest extends TestCase
{
    public static function dataProviderClient(): array
    {
        $config = [];
        $config['handler'] = $handler = HandlerStack::create();
        $handler->push(function (callable $handler) {
            return AutoSkipVerifyMiddleware::middleware($handler);
        });

        return [
            [new Client($config)],
        ];
    }

    /**
     * @dataProvider dataProviderClient
     */
    public function testRequestLazy(Client $client)
    {
        $host = 'www.baidu.com';
        $ip = gethostbyname($host);

        $response = $client->requestLazy(
            'POST',
            sprintf('https://%s/s?ie=UTF-8&wd=response', $ip),
            [
                RequestOptions::HEADERS => [
                    'Host' => $host,
                ],
            ]
        );
        $this->assertIsInt($response->getStatusCode());
    }
}
