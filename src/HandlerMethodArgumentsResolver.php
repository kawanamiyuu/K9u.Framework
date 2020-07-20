<?php

declare(strict_types=1);

namespace K9u\Framework;

use K9u\RequestMapper\HandlerMethodArgumentsResolverInterface;
use K9u\RequestMapper\PathParams;
use Psr\Http\Message\ServerRequestInterface;
use ReflectionMethod;
use ReflectionNamedType;

class HandlerMethodArgumentsResolver implements HandlerMethodArgumentsResolverInterface
{
    public function __invoke(ReflectionMethod $method, ServerRequestInterface $request, PathParams $pathParams): array
    {
        $request = $request->withAttribute(PathParams::class, $pathParams);

        $args = [];
        foreach ($method->getParameters() as $param) {
            if ($param->hasType()) {
                $type = $param->getType();
                assert($type instanceof ReflectionNamedType);

                if (is_a($type->getName(), ServerRequestInterface::class, true)) {
                    $args[] = $request;
                    continue;
                }
            }

            // TODO: assign Path params, Query params, Parsed body, ...
            $args[] = $param->isDefaultValueAvailable() ? $param->getDefaultValue() : null;
        }

        return $args;
    }
}
