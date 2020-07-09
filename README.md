# K9u.Framework

[![badge](https://github.com/kawanamiyuu/K9u.Framework/workflows/CI/badge.svg)](https://github.com/kawanamiyuu/K9u.Framework/actions?query=workflow%3ACI)

```php
use Acme\BarMiddleware;
use Acme\BuzRequestHandler;
use Acme\FooMiddleware;
use K9u\Framework\ApplicationInterface;
use K9u\Framework\FrameworkModule;
use Laminas\Diactoros\ServerRequestFactory;
use Ray\Compiler\ScriptInjector;
use Ray\Di\Bind;
use Ray\Di\InjectorInterface;

$module = new FrameworkModule([
    FooMiddleware::class,
    BarMiddleware::class,
    BuzRequestHandler::class,
]);

$injector = new ScriptInjector('/path/to/cache', function () use (&$injector, $module) {
    (new Bind($module->getContainer(), InjectorInterface::class))->toInstance($injector);
    return $module;
});

$app = $injector->getInstance(ApplicationInterface::class);
assert($app instanceof ApplicationInterface);

$request = ServerRequestFactory::fromGlobals();

$app($request); // handle request and emit response
```
