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
use ICanBoogie\HTTP\RequestDispatcher;
use ICanBoogie\HTTP\WeightedDispatcher;
use ICanBoogie\Routing\ControllerNotDefined;
use ICanBoogie\Routing\RouteDispatcher;
use ICanBoogie\Routing\PatternNotDefined;
use ICanBoogie\Routing\RouteCollection;

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
	 * Adds the `routing` dispatcher.
	 *
	 * @param RequestDispatcher\AlterEvent $event
	 * @param RequestDispatcher $target
	 */
	static public function alter_dispatcher(RequestDispatcher\AlterEvent $event, RequestDispatcher $target)
	{
		$dispatcher = new RouteDispatcher(self::app()->routes);

		$target['routing'] = new WeightedDispatcher($dispatcher, WeightedDispatcher::WEIGHT_TOP);
	}

	/**
	 * Returns the route collection.
	 *
	 * @param Core $app
	 *
	 * @return RouteCollection
	 */
	static public function get_routes(Core $app)
	{
		static $routes;

		if (!$routes)
		{
			$routes = new RouteCollection($app->configs['routes'] ?: []);
		}

		return $routes;
	}

	/**
	 * @return Core|CoreBindings
	 */
	static private function app()
	{
		return \ICanBoogie\app();
	}
}
