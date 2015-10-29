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

use ICanBoogie\HTTP\Request;
use ICanBoogie\HTTP\RequestDispatcher;
use ICanBoogie\Routing\RouteCollection;
use ICanBoogie\Routing\RouteDefinition;
use ICanBoogie\Routing\RouteDispatcher;

class HooksTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var \ICanBoogie\Core|CoreBindings
	 */
	static private $app;

	static public function setUpBeforeClass()
	{
		self::$app = \ICanBoogie\app();
	}

	/**
	 * @expectedException \ICanBoogie\Routing\PatternNotDefined
	 */
	public function test_should_throw_exception_on_empty_pattern()
	{
		Hooks::synthesize_routes_config([

			[
				'one' => [

					RouteDefinition::CONTROLLER => function() {}

				]

			]

		]);
	}

	/**
	 * @expectedException \ICanBoogie\Routing\ControllerNotDefined
	 */
	public function test_should_throw_exception_on_empty_controller()
	{
		Hooks::synthesize_routes_config([

			[
				'one' => [

					RouteDefinition::PATTERN => '/'

				]

			]

		]);
	}

	public function test_should_not_throw_exception_on_empty_controller_if_location_is_defined()
	{
		$fragment = [

			'one' => [

				RouteDefinition::PATTERN => '/',
				RouteDefinition::LOCATION => '/en/'

			]

		];

		$config = Hooks::synthesize_routes_config([ __FILE__ => $fragment ]);

		$this->assertEquals([ 'one' => [

			'__ORIGIN__' => __FILE__,
			RouteDefinition::PATTERN => '/',
			RouteDefinition::LOCATION => '/en/',
			RouteDefinition::VIA => Request::METHOD_ANY

		] ], $config);
	}

	public function test_alter_dispatcher()
	{
		$event = $this
			->getMockBuilder(RequestDispatcher\AlterEvent::class)
			->disableOriginalConstructor()
			->getMock();

		$dispatcher = $this
			->getMockBuilder(RequestDispatcher::class)
			->disableOriginalConstructor()
			->setMethods([ 'offsetSet' ])
			->getMock();
		$dispatcher
			->expects($this->once())
			->method('offsetSet')
			->with('routing');

		/* @var $event RequestDispatcher\AlterEvent */
		/* @var $dispatcher RequestDispatcher */

		Hooks::alter_dispatcher($event, $dispatcher);
	}

	public function test_route_dispatcher_registration()
	{
		$dispatcher = \ICanBoogie\HTTP\get_dispatcher();

		$this->assertInstanceOf(RouteDispatcher::class, $dispatcher['routing']);
	}

	public function test_get_routes()
	{
		$app = self::$app;
		$routes = Hooks::get_routes($app);
		$this->assertInstanceOf(RouteCollection::class, $routes);
		$this->assertSame($routes, Hooks::get_routes($app));
		$this->assertSame($routes, $app->routes);
	}

	public function test_url_for()
	{
		$route_id = 'test:route:' . uniqid();
		$pattern = '/pattern/' . uniqid();

		$app = self::$app;
		$app->routes[$route_id] = [

			RouteDefinition::PATTERN => $pattern,
			RouteDefinition::CONTROLLER => function() {},

		];

		$this->assertEquals($pattern, Hooks::url_for($app, $route_id));
		$this->assertEquals($pattern, Hooks::url_for($app, $app->routes[$route_id]));
	}
}
