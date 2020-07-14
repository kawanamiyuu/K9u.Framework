<?php

declare(strict_types=1);

namespace K9u\Framework;

use K9u\RequestMapper\HandlerClassFactoryInterface;
use Ray\Di\InjectorInterface;

class HandlerClassFactory implements HandlerClassFactoryInterface
{
    private InjectorInterface $injector;

    public function __construct(InjectorInterface $injector)
    {
        $this->injector = $injector;
    }

    public function __invoke(string $class): object
    {
        return $this->injector->getInstance($class);
    }
}
