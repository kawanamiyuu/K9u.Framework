<?php

declare(strict_types=1);

namespace K9u\Framework;

use Ray\Di\AbstractModule;

class AppModule extends AbstractModule
{
    protected function configure()
    {
        $middlewares = [
            FakeMiddleware::class,
            FakeRequestHandler::class
        ];

        $this->install(new FrameworkModule($middlewares));
    }
}
