<?php

declare(strict_types=1);

namespace K9u\Framework\Demo;

use K9u\RequestMapper\Annotation\GetMapping;
use K9u\RequestMapper\PathParams;
use Psr\Http\Message\ServerRequestInterface;

class FakeController
{
    /**
     * @GetMapping("/")
     *
     * @return array<string, mixed>
     */
    public function index(): array
    {
        return ['path' => '/'];
    }

    /**
     * @GetMapping("/blogs")
     *
     * @return array<string, mixed>
     */
    public function getBlogs(): array
    {
        return ['path' => '/blogs'];
    }

    /**
     * @GetMapping("/blogs/{id}")
     *
     * @param ServerRequestInterface $request
     *
     * @return array<string, mixed>
     */
    public function getBlogById(ServerRequestInterface $request): array
    {
        $pathParams = $request->getAttribute(PathParams::class);
        assert($pathParams instanceof PathParams);

        return ['path' => "/blogs/{$pathParams['id']}"];
    }
}
