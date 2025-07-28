<?php
/**
 * Created by PhpStorm.
 * User: hugh.li
 * Date: 2022/3/7
 * Time: 19:32.
 */

namespace HughCube\GuzzleHttp;

use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Throwable;

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

    /**
     * @var null|array
     */
    private $resultArray = null;

    public function __construct(PromiseInterface $promise)
    {
        $this->promise = $promise;
    }

    public function getOriginalResponse(): ResponseInterface
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

    public function toArray($rewind = true): ?array
    {
        if (!$rewind && null !== $this->resultArray) {
            return $this->resultArray;
        }

        $contents = $this->getOriginalResponse()->getBody()->getContents();
        $this->getOriginalResponse()->getBody()->rewind();

        $results = json_decode($contents, true);
        if (JSON_ERROR_NONE === json_last_error()) {
            return $this->resultArray = $results;
        }

        return null;
    }

    public function getBody(): StreamInterface
    {
        return new LazyResponseBody($this);
    }

    /**
     * @inheritDoc
     */
    public function getProtocolVersion(): string
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * @inheritDoc
     */
    public function withProtocolVersion(string $version): MessageInterface
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * @inheritDoc
     */
    public function getHeaders(): array
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * @inheritDoc
     */
    public function hasHeader(string $name): bool
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * @inheritDoc
     */
    public function getHeader(string $name): array
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * @inheritDoc
     */
    public function getHeaderLine(string $name): string
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * @inheritDoc
     */
    public function withHeader(string $name, $value): MessageInterface
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * @inheritDoc
     */
    public function withAddedHeader(string $name, $value): MessageInterface
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * @inheritDoc
     */
    public function withoutHeader(string $name): MessageInterface
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * @inheritDoc
     */
    public function withBody(StreamInterface $body): MessageInterface
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * @inheritDoc
     */
    public function getStatusCode(): int
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * @inheritDoc
     */
    public function withStatus(int $code, string $reasonPhrase = ''): ResponseInterface
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * @inheritDoc
     */
    public function getReasonPhrase(): string
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    public function getBodyContents($rewind = true): string
    {
        $contents = $this->getOriginalResponse()->getBody()->getContents();

        if ($rewind) {
            $this->getOriginalResponse()->getBody()->rewind();
        }

        return $contents;
    }

    public function __destruct()
    {
        try {
            $this->getOriginalResponse();
        } catch (Throwable $throwable) {
        }
    }

    public function __call(string $name, array $arguments = [])
    {
        return $this->call($name, $arguments);
    }
}
