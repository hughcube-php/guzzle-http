<?php
/**
 * Created by PhpStorm.
 * User: hugh.li
 * Date: 2022/3/7
 * Time: 19:32.
 */

namespace HughCube\GuzzleHttp;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class LazyResponseBody implements StreamInterface
{
    /**
     * @var LazyResponse|ResponseInterface
     */
    protected $response = null;

    /**
     * @var StreamInterface
     */
    protected $body = null;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function getBody(): StreamInterface
    {
        if (null === $this->body && $this->response instanceof LazyResponse) {
            $this->body = $this->response->getOriginalResponse()->getBody();
        } elseif (null === $this->body) {
            $this->body = $this->response->getBody();
        }

        return $this->body;
    }

    protected function call(string $method, array $arguments = [])
    {
        return $this->getBody()->$method(...$arguments);
    }

    public function __call(string $name, array $arguments = [])
    {
        return $this->call($name, $arguments);
    }

    public function __toString(): string
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    public function close(): void
    {
        $this->call(__FUNCTION__, func_get_args());
    }

    public function detach()
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    public function getSize(): ?int
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    public function tell(): int
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    public function eof(): bool
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    public function isSeekable(): bool
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    public function seek(int $offset, int $whence = SEEK_SET): void
    {
        $this->call(__FUNCTION__, func_get_args());
    }

    public function rewind(): void
    {
        $this->call(__FUNCTION__, func_get_args());
    }

    public function isWritable(): bool
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    public function write(string $string): int
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    public function isReadable(): bool
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    public function read(int $length): string
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    public function getContents(): string
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    public function getMetadata(?string $key = null)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }
}
