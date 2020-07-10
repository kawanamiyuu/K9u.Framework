# K9u.Framework

[![badge](https://github.com/kawanamiyuu/K9u.Framework/workflows/CI/badge.svg)](https://github.com/kawanamiyuu/K9u.Framework/actions?query=workflow%3ACI)

```php
use Acme\BarMiddleware;
use Acme\BuzRequestHandler;
use Acme\FooMiddleware;
use K9u\Framework\ApplicationInterface;
use K9u\Framework\CachedInjectorFactory;
use K9u\Framework\FrameworkModule;
use Laminas\Diactoros\ServerRequestFactory;

$module = new FrameworkModule([
    FooMiddleware::class,
    BarMiddleware::class,
    BuzRequestHandler::class,
]);

$injector = (new CachedInjectorFactory('/path/to/cache'))($module);

$app = $injector->getInstance(ApplicationInterface::class);
/* @var ApplicationInterface $app */

$request = ServerRequestFactory::fromGlobals();

$app($request); // handle request and emit response
```
