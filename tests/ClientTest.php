<?php
/**
 * Created by PhpStorm.
 * User: hugh.li
 * Date: 2021/4/20
 * Time: 11:36 下午.
 */

namespace HughCube\GuzzleHttp\Tests;

use GuzzleHttp\Exception\GuzzleException;
use HughCube\GuzzleHttp\Client;
use HughCube\GuzzleHttp\ClientInterface;
use HughCube\GuzzleHttp\LazyResponse;
use Psr\Http\Message\ResponseInterface;

class ClientTest extends TestCase
{
    public static function dataProviderClient(): array
    {
        return [
            [new Client()],
        ];
    }

    /**
     * @dataProvider dataProviderClient
     *
     * @return void
     */
    public function testIsPsr(Client $client)
    {
        $this->assertInstanceOf(ClientInterface::class, $client);
    }

    /**
     * @dataProvider dataProviderClient
     *
     * @throws GuzzleException
     */
    public function testRequestLazy(Client $client)
    {
        $response = $client->requestLazy('POST', 'https://www.baidu.com/s?ie=UTF-8&wd=response');
        $this->assertIsInt($response->getStatusCode());
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertInstanceOf(LazyResponse::class, $response);
        $this->assertNull($response->toArray());
        $this->assertNotEmpty($response->getBody()->getContents());

        $response = $client->requestLazy('POST', 'https://apis.map.qq.com/ws/place/v1/suggestion');
        $this->assertIsInt($response->getStatusCode());
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertInstanceOf(LazyResponse::class, $response);
        $this->assertIsArray($results = $response->toArray());
        $this->assertSame($results, json_decode($response->getBody()->getContents(), true));

        $response = $client->request('POST', 'https://www.baidu.com/s?ie=UTF-8&wd=response');
        $this->assertIsInt($response->getStatusCode());
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }
}
