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
use Psr\Http\Client\ClientInterface as PsrClientInterface;
use Psr\Http\Message\ResponseInterface;

class ClientTest extends TestCase
{
    public function dataProviderClient(): array
    {
        return [
            [new Client()]
        ];
    }

    /**
     * @dataProvider dataProviderClient
     * @return void
     */
    public function testIsPsr(Client $client)
    {
        $this->assertInstanceOf(PsrClientInterface::class, $client);
    }

    /**
     * @dataProvider dataProviderClient
     * @return void
     * @throws GuzzleException
     */
    public function testRequestLazy(Client $client)
    {
        $response = $client->requestLazy('POST', 'https://www.baidu.com/s?ie=UTF-8&wd=response');
        $this->assertIsInt($response->getStatusCode());
        $this->assertInstanceOf(ResponseInterface::class, $response);

        $response = $client->request('POST', 'https://www.baidu.com/s?ie=UTF-8&wd=response');
        $this->assertIsInt($response->getStatusCode());
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }
}
