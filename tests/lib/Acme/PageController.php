<?php

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
