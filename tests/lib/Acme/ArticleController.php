<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Test\ICanBoogie\Binding\Routing\Acme;

use ICanBoogie\Binding\Routing\ActionResponder;
use ICanBoogie\Binding\Routing\Attribute\Get;
use ICanBoogie\Binding\Routing\Attribute\Post;
use ICanBoogie\HTTP\Request;
use ICanBoogie\Routing\ControllerAbstract;
use ICanBoogie\Routing\Route;

/**
 * This use case demonstrates how HTTP method attribute can be used on any function, especially when the action is
 * specified. There's also a more complex type of URL pattern for the `show` action.
 */
#[ActionResponder]
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
