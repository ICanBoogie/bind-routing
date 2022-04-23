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
use ICanBoogie\HTTP\RequestMethod;
use ICanBoogie\Routing\Route;
use ICanBoogie\Routing\RouteMaker;
use ICanBoogie\Routing\RouteMaker\Options;
use ICanBoogie\Routing\RouteProvider;

/**
 * A config builder for 'routes' fragments.
 */
final class ConfigBuilder implements Builder
{
	private RouteProvider\Mutable $routes;

	public function __construct()
	{
		$this->routes = new RouteProvider\Mutable();
	}

	public function build(): RouteProvider
	{
		return new RouteProvider\Immutable($this->routes);
	}

	/**
	 * Add a route.
	 *
	 * @param string $pattern Pattern of the route.
	 * @param string $action Identifier of a qualified action. e.g. 'articles:show'.
	 * @param RequestMethod|RequestMethod[] $methods Request method(s) accepted by the route.
	 *
	 * @return $this
	 */
	public function route(
		string $pattern,
		string $action,
		RequestMethod|array $methods = RequestMethod::METHOD_ANY,
		string|null $id = null
	): self
	{
		$this->routes->add_routes(new Route($pattern, $action, $methods, $id));

		return $this;
	}

	/**
	 * Adds resource routes.
	 *
	 * **Note:** The respond definitions for the resource are created by {@link RouteMaker::resource}. Both methods
	 * accept the same arguments.
	 *
	 * @see RouteMaker::resource
	 */
	public function resource(string $name, Options $options = null): self
	{
		$this->routes->add_routes(...RouteMaker::resource($name, $options));

		return $this;
	}
}
