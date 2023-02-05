<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use ICanBoogie\Application;
use ICanBoogie\Binding\Prototype\ConfigBuilder;
use ICanBoogie\Binding\Routing\Hooks;

return fn(ConfigBuilder $config) => $config
    ->bind(Application::class, 'get_routes', [ Hooks::class, 'get_routes' ]);
