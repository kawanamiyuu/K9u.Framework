<?php

declare(strict_types=1);

namespace K9u\Framework;

use PHPUnit\Framework\TestCase;
use Ray\Compiler\DiCompiler;

class FrameworkModuleTest extends TestCase
{
    private const CACHE_DIR = __DIR__ . '/cache';

    public function setUp(): void
    {
        array_map('unlink', glob(self::CACHE_DIR . '/*'));
    }

    public function testCompile(): void
    {
        $module = new FrameworkModule();
        $compiler = new DiCompiler($module, self::CACHE_DIR);
        $instance = $compiler->getInstance(ApplicationInterface::class);

        $this->assertInstanceOf(ApplicationInterface::class, $instance);

//        $compiler->dumpGraph();
    }
}
