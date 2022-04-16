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
use ICanBoogie\Routing\ResponderProvider;
use ICanBoogie\Routing\Route;
use ICanBoogie\Routing\RouteCollection;
use ICanBoogie\Routing\Router;
use ICanBoogie\Routing\UrlGenerator;

final class Hooks
{
	/*
	 * Events
	 */

	/**
	 * Synthesize the `routes` config from `routes` fragments.
	 *
	 * @param array<string, Route[]> $fragments
	 *
	 * @return Route[]
	 */
	static public function synthesize_routes_config(array $fragments): array
	{
		new BeforeSynthesizeRoutesEvent($fragments);

		$routes = [];

		foreach ($fragments as $fragment) {
			foreach ($fragment as $route) {
				$routes[] = $route;
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

		return $routes ??= new RouteCollection($app->configs['routes']);
	}

	static public function get_router(Application $app): Router
	{
		static $router;

		return $router ??= new Router($app->routes, new ResponderProvider\Mutable());
	}

	static public function get_url_generator(Application $app): UrlGenerator
	{
		static $url_generator;

		return $url_generator ??= new UrlGenerator($app->routes);
	}

	/**
	 * Returns the contextualized URL of a route.
	 */
	static public function url_for(Application $app, string|callable $predicate, object|array $params = null): string
	{
		return $app->url_generator->generate_url($predicate, $params);
	}
}
