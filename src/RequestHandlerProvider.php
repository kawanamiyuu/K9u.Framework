<?php

declare(strict_types=1);

namespace K9u\Framework;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Ray\Di\InjectorInterface;
use Ray\Di\ProviderInterface;
use Relay\Relay;

class RequestHandlerProvider implements ProviderInterface
{
    private MiddlewareContainer $middlewareContainer;

    private InjectorInterface $injector;

    public function __construct(MiddlewareContainer $middlewareContainer, InjectorInterface $injector)
    {
        $this->middlewareContainer = $middlewareContainer;
        $this->injector = $injector;
    }

    public function get(): RequestHandlerInterface
    {
        return new Relay($this->middlewareContainer, function ($middleware) {
            $instance = $this->injector->getInstance($middleware);
            assert($instance instanceof MiddlewareInterface || $instance instanceof RequestHandlerInterface);
            return $instance;
        });
    }
}
