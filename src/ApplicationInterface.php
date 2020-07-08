<?php

declare(strict_types=1);

namespace K9u\Framework;

use Psr\Http\Message\ServerRequestInterface;

interface ApplicationInterface
{
    /**
     * @param ServerRequestInterface $request
     */
    public function __invoke(ServerRequestInterface $request): void;
}
