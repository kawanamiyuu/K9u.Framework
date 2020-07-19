<?php

declare(strict_types=1);

namespace K9u\Framework\Demo;

use K9u\RequestMapper\Annotation\GetMapping;

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
}
