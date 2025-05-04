<?php
/**
 * Created by PhpStorm.
 * User: hugh.li
 * Date: 2022/3/7
 * Time: 19:34.
 */

namespace HughCube\GuzzleHttp;

trait HttpClientTrait
{
    /**
     * @var Client
     */
    private $httpClient = null;

    /**
     * @return Client
     */
    protected function getHttpClient(): Client
    {
        if (method_exists($this, 'createHttpClient')) {
            if (!$this->httpClient instanceof Client) {
                $this->httpClient = $this->createHttpClient();
            }
            return $this->httpClient;
        }

        return Once::getDefaultHttpClient();
    }
}
