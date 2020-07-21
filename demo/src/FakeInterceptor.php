<?php

declare(strict_types=1);

namespace K9u\Framework\Demo;

use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;

class FakeInterceptor implements MethodInterceptor
{
    public function invoke(MethodInvocation $invocation)
    {
        $result = $invocation->proceed();
        assert(is_array($result));

        $method = $invocation->getMethod();
        $class = $method->getDeclaringClass();

        return $result + ['handler' => sprintf('%s::%s', $class->getName(), $method->getName())];
    }
}
