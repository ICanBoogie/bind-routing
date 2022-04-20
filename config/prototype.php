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

return [

	'ICanBoogie\Application::lazy_get_routes' => [ Hooks::class, 'get_routes' ],
	'ICanBoogie\Application::lazy_get_router' => [ Hooks::class, 'get_router' ],
	'ICanBoogie\Application::url_for' => [ Hooks::class, 'url_for' ]

];
