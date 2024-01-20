<?php
/**
 * Created by PhpStorm.
 * User: hugh.li
 * Date: 2021/4/20
 * Time: 11:36 下午.
 */

namespace HughCube\GuzzleHttp\Tests;

use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @param string|object $object $object
     * @param string        $method
     * @param array         $args
     *
     * @throws ReflectionException
     *
     * @return mixed
     */
    protected static function callMethod($object, string $method, array $args = [])
    {
        $class = new ReflectionClass($object);

        /** @var ReflectionMethod $method */
        $method = $class->getMethod($method);
        $method->setAccessible(true);

        return $method->invokeArgs(is_object($object) ? $object : null, $args);
    }
}
