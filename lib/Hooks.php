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

final class Hooks
{
	/*
	 * Events
	 */

	/**
	 * Synthesize the `routes` config from `routes` fragments.
	 *
	 * @param array<string, array<string, array>> $fragments
	 *
	 * @return array
	 *
	 * @throws PatternNotDefined if a pattern is missing from a route definition.
	 * @throws ControllerNotDefined if a controller is missing from a route definition and no
	 * location is defined.
	 */
	static public function synthesize_routes_config(array $fragments): array
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
	 */
	static public function get_routes(Application $app): RouteCollection
	{
		static $routes;

		return $routes
			?: $routes = new RouteCollection($app->configs['routes'] ?: [], RouteCollection::TRUSTED_DEFINITIONS);
	}

	/**
	 * Returns the contextualized URL of a route.
	 */
	static public function url_for(Application $app, string|Route $route, object|array $values = null): string
	{
		if (!$route instanceof Route)
		{
			$route = $app->routes[$route];
		}

		$url = $route->format($values);

		return contextualize($url);
	}
}
