<?php

declare(strict_types=1);

use K9u\Framework\ApplicationInterface;
use K9u\Framework\AppModule;
use K9u\Framework\CachedInjectorFactory;
use Laminas\Diactoros\ServerRequestFactory;

const DEMO_ROOT_DIR = __DIR__ . '/..';

require DEMO_ROOT_DIR . '/../vendor/autoload.php';

$module = new AppModule();
$injector = (new CachedInjectorFactory(DEMO_ROOT_DIR . '/cache'))($module);

$app = $injector->getInstance(ApplicationInterface::class);
/* @var ApplicationInterface $app */

$request = ServerRequestFactory::fromGlobals();

$app($request); // handle request and emit response
