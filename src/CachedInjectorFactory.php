<?php

declare(strict_types=1);

namespace K9u\Framework;

use Ray\Compiler\ScriptInjector;
use Ray\Di\AbstractModule;
use Ray\Di\Bind;
use Ray\Di\InjectorInterface;

class CachedInjectorFactory implements InjectorFactoryInterface
{
    private string $cacheDir;

    public function __construct(string $cacheDir)
    {
        $this->cacheDir = $cacheDir;
    }

    public function __invoke(AbstractModule $module): InjectorInterface
    {
        $injector = new ScriptInjector($this->cacheDir, function () use (&$injector, $module) {
            (new Bind($module->getContainer(), InjectorInterface::class))->toInstance($injector);
            return $module;
        });

        return $injector;
    }
}
