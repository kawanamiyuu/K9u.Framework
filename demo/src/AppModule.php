<?php

declare(strict_types=1);

namespace K9u\Framework\Demo;

use K9u\Framework\FrameworkModule;
use K9u\RequestMapper\Annotation\AbstractMapping;
use Ray\Di\AbstractModule;

class AppModule extends AbstractModule
{
    protected function configure()
    {
        $this->bindInterceptor(
            $this->matcher->any(),
            $this->matcher->annotatedWith(AbstractMapping::class),
            [FakeInterceptor::class]
        );

        $middlewares = [
            FakeMiddleware::class
        ];

        $this->install(new FrameworkModule($middlewares));
    }
}
