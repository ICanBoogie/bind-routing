<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Binding\Routing;

use ICanBoogie\Binding\HTTP\AbstractDispatcherConstructor;
use ICanBoogie\HTTP\Dispatcher;
use ICanBoogie\Routing\Responder\RouteResponder;
use ICanBoogie\Routing\ResponderProvider\Mutable;
use ICanBoogie\Routing\RouteDispatcher;

/**
 * Construct a {@link RouteDispatcher} instance.
 *
 * @deprecated
 */
class RouteDispatcherConstructor extends AbstractDispatcherConstructor
{
	/**
	 * @inheritdoc
	 */
	public function __invoke(array $config): Dispatcher
	{
		// TODO: Replace Mutable()
		return new RouteDispatcher(new RouteResponder($this->app->routes, new Mutable()));
	}
}
