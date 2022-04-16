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
use ICanBoogie\Routing\Route;
use ICanBoogie\Routing\RouteCollection;
use ICanBoogie\Routing\RouteDispatcher;
use ICanBoogie\Routing\RouteProvider\ByUri;
use PHPUnit\Framework\TestCase;

use function ICanBoogie\app;
use function ICanBoogie\HTTP\get_dispatcher;

final class HooksTest extends TestCase
{
	static private Application $app;

	static public function setUpBeforeClass(): void
	{
		parent::setUpBeforeClass();

		self::$app = app();
	}

	public function test_route_dispatcher_registration()
	{
		$this->markTestSkipped();

		$dispatcher = get_dispatcher();

		$this->assertInstanceOf(RouteDispatcher::class, $dispatcher['routing']);
	}

	public function test_get_routes(): void
	{
		$app = self::$app;
		$routes = Hooks::get_routes($app);
		$this->assertInstanceOf(RouteCollection::class, $routes);
		$this->assertSame($routes, Hooks::get_routes($app));
		$this->assertSame($routes, $app->routes);

		$this->assertSame(
			'home',
			$app->routes->route_for_predicate(new ByUri('/'))->action
		);
	}

	public function test_url_for()
	{
		$route_id = 'test:route:' . uniqid();
		$pattern = '/pattern/' . uniqid();

		$app = self::$app;
		$app->routes->add_routes(new Route($pattern, 'home', id: $route_id));

		$this->assertEquals($pattern, $app->url_for($route_id));
	}
}
