<?php

declare(strict_types=1);

namespace K9u\Framework;

use K9u\RequestMapper\HandlerClassFactoryInterface;
use K9u\RequestMapper\HandlerCollectorInterface;
use K9u\RequestMapper\HandlerInvoker;
use K9u\RequestMapper\HandlerInvokerInterface;
use K9u\RequestMapper\HandlerMethodArgumentsResolverInterface;
use K9u\RequestMapper\HandlerResolver;
use K9u\RequestMapper\HandlerResolverInterface;
use K9u\RequestMapper\OnDemandHandlerCollector;
use Laminas\Diactoros\ResponseFactory;
use Laminas\Diactoros\StreamFactory;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Ray\Di\AbstractModule;
use Ray\Di\Scope;

/**
 * @SuppressWarnings("PHPMD.CouplingBetweenObjects")
 */
class FrameworkModule extends AbstractModule
{
    /**
     * @var array<class-string>
     */
    private array $middlewares;

    private string $handlerDir;

    /**
     * @param array<class-string> $middlewares
     * @param string|null         $handlerDir
     * @param AbstractModule|null $module
     */
    public function __construct(array $middlewares = [], string $handlerDir = null, AbstractModule $module = null)
    {
        $this->middlewares = array_merge($middlewares, [RequestMappingHandler::class]);

        $this->handlerDir = $handlerDir ?? dirname(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 0)[0]['file']);
        assert(is_dir($this->handlerDir));

        parent::__construct($module);
    }

    protected function configure(): void
    {
        $this->bind()->annotatedWith('handler_dir')
            ->toInstance($this->handlerDir);

        $this->bind(HandlerCollectorInterface::class)
            ->toConstructor(OnDemandHandlerCollector::class, ['baseDir' => 'handler_dir'])
            ->in(Scope::SINGLETON);

        $this->bind(HandlerResolverInterface::class)
            ->to(HandlerResolver::class)->in(Scope::SINGLETON);

        $this->bind(HandlerClassFactoryInterface::class)
            ->to(HandlerClassFactory::class)->in(Scope::SINGLETON);

        $this->bind(HandlerMethodArgumentsResolverInterface::class)
            ->to(HandlerMethodArgumentsResolver::class)->in(Scope::SINGLETON);

        $this->bind(HandlerInvokerInterface::class)
            ->to(HandlerInvoker::class)->in(Scope::SINGLETON);

        foreach ($this->middlewares as $middleware) {
            $this->bind($middleware)->in(Scope::SINGLETON);
        }

        $this->bind()->annotatedWith(MiddlewareCollection::class)
            ->toInstance($this->middlewares);

        $this->bind(RequestHandlerInterface::class)
            ->toProvider(RequestHandlerProvider::class)->in(Scope::SINGLETON);

        $this->bind(ExceptionHandlerInterface::class)
            ->to(ExceptionHandler::class)->in(Scope::SINGLETON);

        $this->bind(ResponseEmitterInterface::class)
            ->to(ResponseEmitter::class)->in(Scope::SINGLETON);

        $this->bind(ResponseFactoryInterface::class)
            ->to(ResponseFactory::class)->in(Scope::SINGLETON);

        $this->bind(StreamFactoryInterface::class)
            ->to(StreamFactory::class)->in(Scope::SINGLETON);

        $this->bind(ApplicationInterface::class)
            ->to(Application::class)->in(Scope::SINGLETON);
    }
}
