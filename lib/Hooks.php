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
use ICanBoogie\Routing\ControllerNotDefined;
use ICanBoogie\Routing\Route;
use ICanBoogie\Routing\RouteDefinition;
use ICanBoogie\Routing\PatternNotDefined;
use ICanBoogie\Routing\RouteCollection;

use function ICanBoogie\Routing\contextualize;

class Hooks
{
	/*
	 * Events
	 */

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
			foreach ($fragment as $id => $definition)
			{
				RouteDefinition::assert_is_valid($definition);
				RouteDefinition::normalize($definition);

				$routes[$id] = [ '__ORIGIN__' => $pathname ] + $definition;
			}
		}

		new SynthesizeRoutesEvent($routes);

		return $routes;
	}

	/*
	 * Prototypes
	 */

	/**
	 * Returns the route collection.
	 *
	 * @param Application $app
	 *
	 * @return RouteCollection
	 */
	static public function get_routes(Application $app)
	{
		static $routes;

		return $routes
			?: $routes = new RouteCollection($app->configs['routes'] ?: [], RouteCollection::TRUSTED_DEFINITIONS);
	}

	/**
	 * Returns the contextualized URL of a route.
	 *
	 * @param Application $app
	 * @param string|Route $route
	 * @param array|object|null $values
	 *
	 * @return string
	 */
	static public function url_for(Application $app, $route, $values = null)
	{
		if (!$route instanceof Route)
		{
			$route = $app->routes[$route];
		}

		$url = $route->format($values);

		return contextualize($url);
	}
}
