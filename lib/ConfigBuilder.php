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

use ICanBoogie\Config\Builder;
use ICanBoogie\Routing\RouteCollector;
use ICanBoogie\Routing\RouteProvider;

/**
 * A config builder for 'routes' fragments.
 *
 * @implements Builder<RouteProvider>
 */
final class ConfigBuilder extends RouteCollector implements Builder
{
    public static function get_fragment_filename(): string
    {
        return 'routes';
    }

    public function build(): RouteProvider
    {
        return $this->collect();
    }
}
