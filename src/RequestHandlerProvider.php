<?php

declare(strict_types=1);

namespace K9u\Framework;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Ray\Di\Di\Named;
use Ray\Di\InjectorInterface;
use Ray\Di\ProviderInterface;
use Relay\Relay;

class RequestHandlerProvider implements ProviderInterface
{
    /**
     * @var array<class-string>
     */
    private array $middlewares;

    private InjectorInterface $injector;

    /**
     * @Named("middlewares=middleware_collection")
     *
     * @param array<class-string> $middlewares
     * @param InjectorInterface   $injector
     */
    public function __construct(array $middlewares, InjectorInterface $injector)
    {
        $this->middlewares = $middlewares;
        $this->injector = $injector;
    }

    public function get(): RequestHandlerInterface
    {
        return new Relay($this->middlewares, function ($middleware) {
            $instance = $this->injector->getInstance($middleware);
            assert($instance instanceof MiddlewareInterface || $instance instanceof RequestHandlerInterface);
            return $instance;
        });
    }
}
