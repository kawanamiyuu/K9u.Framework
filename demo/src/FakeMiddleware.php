<?php

declare(strict_types=1);

namespace K9u\Framework\Demo;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class FakeMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);

        foreach ($request->getHeaders() as $name => $values) {
            $response = $response->withHeader("X-Request-{$name}", $values);
        }

        return $response;
    }
}
