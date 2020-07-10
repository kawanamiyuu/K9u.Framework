<?php

declare(strict_types=1);

namespace K9u\Framework;

use Ray\Di\AbstractModule;
use Ray\Di\Injector;
use Ray\Di\InjectorInterface;

class OnDemandInjectorFactory implements InjectorFactoryInterface
{
    public function __invoke(AbstractModule $module): InjectorInterface
    {
        return new Injector($module);
    }
}
