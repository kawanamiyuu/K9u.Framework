<?php

declare(strict_types=1);

namespace K9u\Framework;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

interface ExceptionHandlerInterface
{
    public function __invoke(Throwable $throwable, ServerRequestInterface $request): ResponseInterface;
}
