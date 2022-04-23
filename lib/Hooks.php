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
use ICanBoogie\Routing\UrlGenerator;

final class Hooks
{
    /*
     * Prototypes
     */

    /**
     * Returns the route collection.
     */
    public static function get_routes(Application $app): IterableRouteProvider
    {
        static $routes;

        return $routes ??= $app->configs['routes'];
    }

    /**
     * Returns the contextualized URL of a route.
     *
     * @phpstan-param string|(callable(\ICanBoogie\Routing\Route): bool) $predicate_or_id_or_action
     *
     * @param array<string, mixed>|object|null $path_params
     *     Parameters that reference placeholders in the route pattern.
     * @param array<string, mixed>|object|null $query_params
     *     Parameters for the query string.
     */
    public static function url_for(
        Application $app,
        string|callable $predicate_or_id_or_action,
        array|object|null $path_params = null,
        array|object|null $query_params = null,
    ): string {
        return $app->service_for_class(UrlGenerator::class)
            ->generate_url($predicate_or_id_or_action, $path_params, $query_params);
    }
}
