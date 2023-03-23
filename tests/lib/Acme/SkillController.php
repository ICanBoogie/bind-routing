<?php

namespace Test\ICanBoogie\Binding\Routing\Acme;

use ICanBoogie\Binding\Routing\Attribute\Delete;
use ICanBoogie\Binding\Routing\Attribute\Get;
use ICanBoogie\Binding\Routing\Attribute\Post;
use ICanBoogie\Binding\Routing\Attribute\Put;
use ICanBoogie\Binding\Routing\Attribute\Route;
use ICanBoogie\Routing\Controller\ActionTrait;
use ICanBoogie\Routing\ControllerAbstract;

/**
 * This use case demonstrates how the {@link Route} attribute can be used to prefix HTTP methods.
 */
#[Route('/skills')]
final class SkillController extends ControllerAbstract
{
    use ActionTrait;

    /**
     * This should create a route with pattern `/skills`.
     */
    #[Get]
    protected function list(): void
    {
    }

    /**
     * This should create a route with pattern `/skills/:slug.html`.
     */
    #[Get('/:slug.html')]
    protected function show(string $slug): void
    {
    }

    #[Post]
    protected function create(): void
    {
    }

    #[Put('/:id')]
    protected function update(int $id): void
    {
    }

    #[Delete('/:id')]
    protected function delete(int $id): void
    {
    }
}
