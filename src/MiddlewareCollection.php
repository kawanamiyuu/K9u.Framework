<?php

declare(strict_types=1);

namespace K9u\Framework;

use Ray\Di\Di\Qualifier;

/**
 * @Annotation
 * @Target("METHOD")
 * @Qualifier
 */
final class MiddlewareCollection
{
    public string $value;
}
