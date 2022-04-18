<?php

namespace Test\ICanBoogie\Binding\Routing;

use ICanBoogie\HTTP\Request;
use ICanBoogie\Routing\ControllerAbstract;
use ICanBoogie\Routing\Route;

class ArticleController extends ControllerAbstract
{
	protected function action(Request $request): string
	{
		return $request->context->get(Route::class)->action;
	}
}
