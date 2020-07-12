<?php

declare(strict_types=1);

namespace K9u\Framework;

use PHPUnit\Framework\TestCase;
use Ray\Compiler\DiCompiler;

class FrameworkModuleTest extends TestCase
{
    public function setUp(): void
    {
        array_map('unlink', glob(__DIR__ . '/../build/tests/*'));
    }

    public function testCompile(): void
    {
        $module = new FrameworkModule();
        $compiler = new DiCompiler($module, __DIR__ . '/../build/tests');
        $instance = $compiler->getInstance(ApplicationInterface::class);

        $this->assertInstanceOf(ApplicationInterface::class, $instance);

//        $compiler->dumpGraph();
    }
}
