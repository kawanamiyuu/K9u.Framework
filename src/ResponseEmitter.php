<?php

declare(strict_types=1);

namespace K9u\Framework;

use Laminas\HttpHandlerRunner\Emitter\SapiStreamEmitter;
use Psr\Http\Message\ResponseInterface;

class ResponseEmitter implements ResponseEmitterInterface
{
    public function __invoke(ResponseInterface $response): void
    {
        (new SapiStreamEmitter())->emit($response);
    }
}
