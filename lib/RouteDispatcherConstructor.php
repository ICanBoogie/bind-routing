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

use ICanBoogie\Application;
use ICanBoogie\Binding\HTTP\AbstractDispatcherConstructor;
use ICanBoogie\HTTP\Dispatcher;
use ICanBoogie\Routing\RouteDispatcher;

/**
 * Construct a {@link RouteDispatcher} instance.
 */
class RouteDispatcherConstructor extends AbstractDispatcherConstructor
{
	/**
	 * @inheritdoc
	 */
	public function __invoke(array $config): Dispatcher
	{
		return new RouteDispatcher($this->app->routes);
	}
}
