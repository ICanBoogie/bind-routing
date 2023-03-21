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

use ICanBoogie\Binding\Routing\Action;
use ICanBoogie\HTTP\Request;
use ICanBoogie\Routing\ControllerAbstract;
use ICanBoogie\Routing\Route;

final class ArticleController extends ControllerAbstract
{
    #[Action('articles:show')]
    #[Action('articles:create')]
    protected function action(Request $request): string
    {
        return $request->context->get(Route::class)->action;
    }

    #[Action]
    protected function home(): void
    {
    }
}
