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
use ICanBoogie\Routing\IterableRouteProvider;
use ICanBoogie\Routing\RouteProvider;

final class Hooks
{
    /**
     * Returns the route collection.
     */
    public static function get_routes(Application $app): IterableRouteProvider
    {
        static $routes;

        return $routes ??= $app->configs->config_for_class(RouteProvider::class);
    }
}
