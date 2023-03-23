<?php

namespace Test\ICanBoogie\Binding\Routing\Acme;

use ICanBoogie\Binding\Routing\ActionResponder;
use ICanBoogie\Binding\Routing\Attribute\Delete;
use ICanBoogie\Binding\Routing\Attribute\Get;
use ICanBoogie\Binding\Routing\Attribute\Post;
use ICanBoogie\Binding\Routing\Attribute\Put;
use ICanBoogie\Routing\Controller\ActionTrait;
use ICanBoogie\Routing\ControllerAbstract;

/**
 * This use case demonstrates how HTTP method attributes can be used to define routes.
 * When the `action` parameter is undefined, the value is inferred from the controller class and the method name.
 */
#[ActionResponder]
final class ImageController extends ControllerAbstract
{
    use ActionTrait;

    #[Get('/images.html')]
    public function list(): void
    {
    }

    #[Get('/images/:id.html')]
    public function show(): void
    {
    }

    #[Post('/images')]
    public function create(): void
    {
    }

    #[Put('/images/:id')]
    public function update(): void
    {
    }

    #[Delete('/images/:id')]
    public function delete(): void
    {
    }
}
