<?php
/**
 * Created by PhpStorm.
 * User: hugh.li
 * Date: 2022/3/7
 * Time: 22:43.
 */

namespace HughCube\GuzzleHttp\Tests;

use HughCube\GuzzleHttp\Client;
use HughCube\GuzzleHttp\HttpClientTrait;
use PHPUnit\Framework\MockObject\Exception;
use ReflectionException;

class HttpClientTraitTest extends TestCase
{
    /**
     * @throws ReflectionException
     * @throws Exception
     *
     * @return void
     */
    public function testGetHttpClient()
    {
        $instance = $this->getMockForTrait(HttpClientTrait::class);

        $this->assertInstanceOf(Client::class, $this->callMethod($instance, 'getHttpClient'));

        $this->assertSame(
            $this->callMethod($instance, 'getHttpClient'),
            $this->callMethod($instance, 'getHttpClient')
        );
    }
}
