<?php
/**
 * Created by PhpStorm.
 * User: hugh.li
 * Date: 2022/3/7
 * Time: 19:35
 */

namespace HughCube\GuzzleHttp;

use GuzzleHttp\Client as BaseClient;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

/**
 * @mixin BaseClient
 */
class Client implements ClientInterface
{
    /**
     * @var BaseClient
     */
    private $httpClient;

    /**
     * @param  array  $config
     */
    public function __construct(array $config = [])
    {
        $this->httpClient = new BaseClient($config);
    }

    /**
     * @inheritDoc
     */
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        return $this->httpClient->sendRequest($request);
    }

    /**
     * @param  string  $name
     * @param  array  $arguments
     * @return mixed
     */
    public function __call(string $name, array $arguments = [])
    {
        return $this->httpClient->$name(...$arguments);
    }

    /**
     * @param  string  $method
     * @param  string|UriInterface  $uri
     * @param  array  $options
     * @return LazyResponse
     */
    public function requestLazy(string $method, $uri = '', array $options = []): LazyResponse
    {
        $promise = $this->requestAsync($method, $uri, $options);
        return new LazyResponse($promise);
    }

    /**
     * @param  string|UriInterface  $uri
     * @param  array  $options
     * @return LazyResponse
     */
    public function getLazy($uri, array $options = []): LazyResponse
    {
        return $this->requestLazy('GET', $uri, $options);
    }

    /**
     * @param  string|UriInterface  $uri
     * @param  array  $options
     * @return LazyResponse
     */
    public function headLazy($uri, array $options = []): LazyResponse
    {
        return $this->requestLazy('HEAD', $uri, $options);
    }

    /**
     * @param  string|UriInterface  $uri
     * @param  array  $options
     * @return LazyResponse
     */
    public function putLazy($uri, array $options = []): LazyResponse
    {
        return $this->requestLazy('PUT', $uri, $options);
    }

    /**
     * @param  string|UriInterface  $uri
     * @param  array  $options
     * @return LazyResponse
     */
    public function postLazy($uri, array $options = []): LazyResponse
    {
        return $this->requestLazy('POST', $uri, $options);
    }

    /**
     * @param  string|UriInterface  $uri
     * @param  array  $options
     * @return LazyResponse
     */
    public function patchLazy($uri, array $options = []): LazyResponse
    {
        return $this->requestLazy('PATCH', $uri, $options);
    }

    /**
     * @param  string|UriInterface  $uri
     * @param  array  $options
     * @return LazyResponse
     */
    public function deleteLazy($uri, array $options = []): LazyResponse
    {
        return $this->requestLazy('DELETE', $uri, $options);
    }
}
