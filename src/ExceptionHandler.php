<?php

declare(strict_types=1);

namespace K9u\Framework;

use K9u\RequestMapper\Exception\HandlerNotFoundException;
use K9u\RequestMapper\Exception\MethodNotAllowedException;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

class ExceptionHandler implements ExceptionHandlerInterface
{
    private ResponseFactoryInterface $responseFactory;

    public function __construct(ResponseFactoryInterface $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public function __invoke(Throwable $throwable, ServerRequestInterface $request): ResponseInterface
    {
        unset($request); // unused

        error_log((string) $throwable);

        return $this->responseFactory->createResponse(self::getStatusCode($throwable));
    }

    private static function getStatusCode(Throwable $throwable): int
    {
        if ($throwable instanceof HandlerNotFoundException) {
            return 404;
        } elseif ($throwable instanceof MethodNotAllowedException) {
            return 405;
        }

        return 500;
    }
}
