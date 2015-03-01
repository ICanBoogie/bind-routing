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

use ICanBoogie\Core;
use ICanBoogie\Routing\ControllerNotDefined;
use ICanBoogie\Routing\PatternNotDefined;
use ICanBoogie\Routing\Routes;

class Hooks
{
	/**
	 * Synthesize the `routes` config from `routes` fragments.
	 *
	 * @param array $fragments
	 *
	 * @return array
	 *
	 * @throws PatternNotDefined if a pattern is missing from a route definition.
	 * @throws ControllerNotDefined if a controller is missing from a route definition and no
	 * location is defined.
	 */
	static public function synthesize_routes_config(array $fragments)
	{
		new BeforeSynthesizeRoutesEvent($fragments);

		$routes = [];

		foreach ($fragments as $pathname => $fragment)
		{
			foreach ($fragment as $id => $route)
			{
				if (empty($route['pattern']))
				{
					throw new PatternNotDefined(\ICanBoogie\format("Pattern is not defined for route %id in %pathname.", [

						'id' => $id,
						'pathname' => $pathname

					]));
				}

				if (empty($route['controller']) && empty($route['location']))
				{
					throw new ControllerNotDefined(\ICanBoogie\format("Controller is not defined for route %id in %pathname.", [

						'id' => $id,
						'pathname' => $pathname

					]));
				}

				$routes[$id] = $route;
			}
		}

		new SynthesizeRoutesEvent($routes);

		return $routes;
	}

	/**
	 * Returns the route collection.
	 *
	 * @param Core $app
	 *
	 * @return Routes
	 */
	static public function get_routes(Core $app)
	{
		static $routes;

		if (!$routes)
		{
			$routes = new Routes((array) $app->configs['routes']);
		}

		return $routes;
	}
}
