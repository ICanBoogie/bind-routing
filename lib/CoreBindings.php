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

use ICanBoogie\Routing\RouteCollection;

/**
 * {@link \ICanBoogie\Core} bindings.
 *
 * @property RouteCollection $routes
 */
trait CoreBindings
{
	/**
	 * @return RouteCollection
	 *
	 * @see Hooks::get_routes
	 */
	protected function lazy_get_routes()
	{
		return parent::lazy_get_routes();
	}
}
