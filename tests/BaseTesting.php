<?php

namespace LojaVirtual\SDKPix\Tests;

use PHPUnit\Framework\TestCase;

/**
 * Base Testing
 */
class BaseTesting extends TestCase
{
    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * Call non-public methods
     *
     * @example
     *
     * $returnValue = self::callMethod($obj, 'methodName', [$arg1, $arg2...]);
     *
     * @param $obj
     * @param $method
     * @param array $arguments
     * @return mixed
     * @throws \ReflectionException
     */
    public static function callMethod($obj, $method, array $arguments)
    {
        $class = new \ReflectionClass($obj);
        $method = $class->getMethod($method);
        $method->setAccessible(true);

        return $method->invokeArgs($obj, $arguments);
    }
}
