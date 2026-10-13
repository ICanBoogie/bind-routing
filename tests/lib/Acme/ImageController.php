<?php

namespace Test\ICanBoogie\Binding\Routing\Acme;

use ICanBoogie\HTTP\Response;
use ICanBoogie\Routing\Attribute\Delete;
use ICanBoogie\Routing\Attribute\Get;
use ICanBoogie\Routing\Attribute\Post;
use ICanBoogie\Routing\Attribute\Put;

/**
 * This use case demonstrates how HTTP method attributes can be used to define routes.
 * When the `action` parameter is undefined, the value is inferred from the controller class and the method name.
 */
final class ImageController
{
    #[Get('/images.html')]
    public function list(): Response
    {
        return new Response();
    }

    #[Get('/images/:id.html')]
    public function show(int $id): Response
    {
        return new Response();
    }

    #[Post('/images')]
    public function create(): Response
    {
        return new Response();
    }

    #[Put('/images/:id')]
    public function update(int $id): Response
    {
        return new Response();
    }

    #[Delete('/images/:id')]
    public function delete(int $id): Response
    {
        return new Response();
    }
}
