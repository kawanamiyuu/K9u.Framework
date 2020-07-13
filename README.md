# K9u.Framework

[![badge](https://github.com/kawanamiyuu/K9u.Framework/workflows/CI/badge.svg)](https://github.com/kawanamiyuu/K9u.Framework/actions?query=workflow%3ACI)

## Overview

```php
use K9u\Framework\ApplicationInterface;
use K9u\Framework\CachedInjectorFactory;
use K9u\Framework\Demo\FakeMiddleware;
use K9u\Framework\Demo\FakeRequestHandler;
use K9u\Framework\FrameworkModule;
use Laminas\Diactoros\ServerRequestFactory;
use Ray\Di\AbstractModule;

class AppModule extends AbstractModule
{
    protected function configure()
    {
        $middlewares = [
            FakeMiddleware::class,
            FakeRequestHandler::class
        ];

        $this->install(new FrameworkModule($middlewares));
    }
}

$module = new AppModule();
$injector = (new CachedInjectorFactory('/path/to/cache'))($module);

$app = $injector->getInstance(ApplicationInterface::class);
/* @var ApplicationInterface $app */

$request = ServerRequestFactory::fromGlobals();

$app($request); // handle request and emit response
```

## Run demo application

See [demo](demo/).

```bash
git clone https://github.com/kawanamiyuu/K9u.Framework.git
cd K9u.Framework
composer install
composer serve:demo

# access to http://localhost:8080
```
