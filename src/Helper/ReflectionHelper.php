<?php

namespace App\Helper;

class ReflectionHelper
{
    public static function ivokePrivateMethod(object $orderService, string $methodName, array $args = []): mixed
    {
        $reflection = new \ReflectionClass(get_class($orderService));

        $method = $reflection->getMethod($methodName);

        $method->setAccessible(true);

        return $method->invokeArgs($orderService, $args);
    }
}