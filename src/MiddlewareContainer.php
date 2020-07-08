<?php

declare(strict_types=1);

namespace K9u\Framework;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * @implements \IteratorAggregate<class-string>
 */
class MiddlewareContainer implements IteratorAggregate
{
    /**
     * @var array<class-string> $middlewares
     */
    private array $middlewares;

    /**
     * @param array<class-string> $middlewares
     */
    public function __construct(array $middlewares)
    {
        $this->middlewares = $middlewares;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->middlewares);
    }
}
