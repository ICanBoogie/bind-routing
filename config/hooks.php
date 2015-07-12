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

$hooks = __NAMESPACE__ . '\Hooks::';

return [

	'events' => [

		'ICanBoogie\HTTP\Dispatcher::alter' => $hooks . 'alter_dispatcher'

	],

	'prototypes' => [

		'ICanBoogie\Core::lazy_get_routes' => $hooks . 'get_routes'

	]

];
