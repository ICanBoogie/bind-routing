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

use ICanBoogie\HTTP\Response;
use ICanBoogie\Routing\Attribute\Get;
use ICanBoogie\Routing\Attribute\Post;
use ICanBoogie\Routing\Attribute\Prefix;

/**
 * This use case demonstrates how HTTP method attribute can be used on any method, especially when the action is
 * specified. There's also a more complex type of URL pattern for the `show` action.
 */
final class ArticleController
{
    #[Post('/articles', action: 'articles:create')]
    public function store(): Response
    {
        return new Response('articles:create');
    }

    #[Get('/articles')]
    public function list(): Response
    {
        return new Response('articles:list');
    }

    #[Get('/articles/<year:\d{4}>-<month:\d{2}>-:slug')]
    public function show(int $year, int $month, string $slug): Response
    {
        return new Response("articles:show $year-$month-$slug");
    }
}
