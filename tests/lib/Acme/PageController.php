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

use ICanBoogie\HTTP\Request;
use ICanBoogie\HTTP\Response;
use ICanBoogie\Routing\ControllerAbstract;
use ICanBoogie\Routing\Route;

final class PageController extends ControllerAbstract
{
    protected function action(Request $request): Response
    {
        return new Response($request->context->get(Route::class)->action);
    }
}
