<?php

namespace Test\ICanBoogie\Binding\Routing\Acme;

use ICanBoogie\Binding\Routing\Attribute\Get;
use ICanBoogie\Binding\Routing\Attribute\Post;
use ICanBoogie\HTTP\Request;
use ICanBoogie\Routing\ControllerAbstract;
use ICanBoogie\Routing\Route;

/**
 * This use case demonstrates how the HTTP method attribute can be used on any function, especially when the action is
 * specified. There is also a more complex type of URL pattern for the `show` action.
 */
final class ArticleController extends ControllerAbstract
{
    #[Post('/articles', 'articles:create')]
    protected function action(Request $request): string
    {
        return $request->context->get(Route::class)->action;
    }

    #[Get('/articles')]
    protected function list(): void
    {
    }

    #[Get('/articles/<year:\d{4}>-<month:\d{2}>-:slug')]
    protected function show(int $year, int $month, string $slug): void
    {
    }
}
