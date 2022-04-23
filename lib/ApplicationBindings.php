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

use ICanBoogie\Routing\IterableRouteProvider;

/**
 * {@link \ICanBoogie\Application} bindings.
 *
 * @method string url_for(string|callable $predicate_or_id_or_action, array|object|null $path_params = null, array|object $query_params = null)
 *     Returns the contextualized URL of a route.
 *
 * @property IterableRouteProvider $routes
 *
 * @see Hooks::url_for()
 * @see Hooks::get_routes()
 */
trait ApplicationBindings
{
}
