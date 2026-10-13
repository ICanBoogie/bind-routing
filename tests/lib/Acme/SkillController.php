<?php

namespace Test\ICanBoogie\Binding\Routing\Acme;

use ICanBoogie\HTTP\Response;
use ICanBoogie\Routing\Attribute\Delete;
use ICanBoogie\Routing\Attribute\Get;
use ICanBoogie\Routing\Attribute\Post;
use ICanBoogie\Routing\Attribute\Prefix;
use ICanBoogie\Routing\Attribute\Put;

/**
 * This use case demonstrates how the {@see Prefix} attribute can be used to prefix HTTP methods.
 */
#[Prefix(pattern: '/skills')]
final class SkillController
{
    /**
     * This should create a route with pattern `/skills`.
     */
    #[Get]
    public function list(): Response
    {
        return new Response();
    }

    /**
     * This should create a route with pattern `/skills/:slug.html`.
     */
    #[Get('/:slug.html')]
    public function show(string $slug): Response
    {
        return new Response();
    }

    #[Post]
    public function create(): Response
    {
        return new Response();
    }

    #[Put('/:id')]
    public function update(int $id): Response
    {
        return new Response();
    }

    #[Delete('/:id')]
    public function delete(int $id): Response
    {
        return new Response();
    }
}
