<?php

declare(strict_types=1);

namespace K9u\Framework;

use Ray\Di\AbstractModule;
use Ray\Di\InjectorInterface;

interface InjectorFactoryInterface
{
    public function __invoke(AbstractModule $module): InjectorInterface;
}
