<?php

declare(strict_types=1);

namespace K9u\Framework;

use JsonException;
use K9u\RequestMapper\Exception\HandlerNotFoundException;
use K9u\RequestMapper\Exception\MethodNotAllowedException;
use K9u\RequestMapper\HandlerInvokerInterface;
use K9u\RequestMapper\HandlerResolverInterface;
use LogicException;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RequestMappingHandler implements RequestHandlerInterface
{
    private ResponseFactoryInterface $responseFactory;

    private StreamFactoryInterface $streamFactory;

    private HandlerResolverInterface $handlerResolver;

    private HandlerInvokerInterface $handlerInvoker;

    public function __construct(
        ResponseFactoryInterface $responseFactory,
        StreamFactoryInterface $streamFactory,
        HandlerResolverInterface $handlerResolver,
        HandlerInvokerInterface $handlerInvoker
    ) {
        $this->responseFactory = $responseFactory;
        $this->streamFactory = $streamFactory;
        $this->handlerResolver = $handlerResolver;
        $this->handlerInvoker = $handlerInvoker;
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     * @throws HandlerNotFoundException
     * @throws MethodNotAllowedException
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $handler = ($this->handlerResolver)($request);
        $invoked = ($this->handlerInvoker)($handler, $request);

        if ($invoked instanceof ResponseInterface) {
            return $invoked;
        }

        // TODO: detect content-type
        try {
            $json = json_encode($invoked, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new LogicException('can not encode to JSON', 0, $e);
        }

        $contentType = 'application/json; charset=utf-8';
        $body = $this->streamFactory->createStream($json);

        return $this->responseFactory->createResponse(200)
            ->withHeader('Content-Type', $contentType)
            ->withBody($body);
    }
}
