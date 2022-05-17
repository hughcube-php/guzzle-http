<?php
/**
 * Created by PhpStorm.
 * User: hugh.li
 * Date: 2022/3/7
 * Time: 19:32.
 */

namespace HughCube\GuzzleHttp;

use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class LazyResponse implements ResponseInterface
{
    /**
     * @var PromiseInterface
     */
    protected $promise;

    /**
     * @var ResponseInterface
     */
    private $result;

    public function __construct(PromiseInterface $promise)
    {
        $this->promise = $promise;
    }

    protected function getOriginalResponse(): ResponseInterface
    {
        if (!$this->result instanceof ResponseInterface) {
            $this->result = $this->promise->wait();
        }
        return $this->result;
    }

    protected function call(string $method, array $arguments = [])
    {
        return $this->getOriginalResponse()->$method(...$arguments);
    }

    public function toArray(): ?array
    {
        $contents = $this->getBody()->getContents();
        $this->getBody()->rewind();

        $results = json_decode($contents, true);
        if (JSON_ERROR_NONE === json_last_error()) {
            return $results;
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function getProtocolVersion()
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * @inheritDoc
     */
    public function withProtocolVersion($version)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * @inheritDoc
     */
    public function getHeaders()
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * @inheritDoc
     */
    public function hasHeader($name)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * @inheritDoc
     */
    public function getHeader($name)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * @inheritDoc
     */
    public function getHeaderLine($name)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * @inheritDoc
     */
    public function withHeader($name, $value)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * @inheritDoc
     */
    public function withAddedHeader($name, $value)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * @inheritDoc
     */
    public function withoutHeader($name)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * @inheritDoc
     */
    public function getBody()
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * @inheritDoc
     */
    public function withBody(StreamInterface $body)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * @inheritDoc
     */
    public function getStatusCode()
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * @inheritDoc
     */
    public function withStatus($code, $reasonPhrase = '')
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * @inheritDoc
     */
    public function getReasonPhrase()
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    public function __destruct()
    {
        $this->getOriginalResponse();
    }

    public function __call(string $name, array $arguments = [])
    {
        return $this->call($name, $arguments);
    }
}
