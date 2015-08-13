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
 * @method string url_for($route_or_route_id, $values = null) Returns the contextualized URL of a route.
 *
 * @property RouteCollection $routes
 *
 * @see \ICanBoogie\Binding\Routing\Hooks::url_for()
 * @see \ICanBoogie\Binding\Routing\Hooks::get_routes()
 */
trait CoreBindings
{

}
