<?php

declare(strict_types=1);

namespace K9u\Framework;

use K9u\RequestMapper\HandlerMethodArgumentsResolverInterface;
use K9u\RequestMapper\PathParams;
use Psr\Http\Message\ServerRequestInterface;
use ReflectionMethod;

class HandlerMethodArgumentsResolver implements HandlerMethodArgumentsResolverInterface
{
    public function __invoke(ReflectionMethod $method, ServerRequestInterface $request, PathParams $pathParams): array
    {
        unset($request); // unused
        unset($pathParams); // unused

        $args = [];
        foreach ($method->getParameters() as $param) {
            // TODO: assign Path params, Query params, Parsed body, ...
            $args[] = $param->isDefaultValueAvailable() ? $param->getDefaultValue() : null;
        }

        return $args;
    }
}
