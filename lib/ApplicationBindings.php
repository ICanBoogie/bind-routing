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
use ICanBoogie\Routing\Route;
use ICanBoogie\Routing\Router;
use ICanBoogie\Routing\UrlGenerator;

/**
 * {@link \ICanBoogie\Application} bindings.
 *
 * @method string url_for(Route|string $route_or_route_id, array|object $values = null) Returns the contextualized URL of a route.
 *
 * @property IterableRouteProvider $routes
 * @property Router $router
 * @property UrlGenerator $url_generator
 *
 * @see Hooks::url_for()
 * @see Hooks::get_routes()
 * @see Hooks::get_router()
 * @see Hooks::get_url_generator()
 */
trait ApplicationBindings
{

}
