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

use ICanBoogie\HTTP\RequestDispatcher;
use ICanBoogie\Routing\RouteCollection;
use ICanBoogie\Routing\RouteDispatcher;

class HooksTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @expectedException \ICanBoogie\Routing\PatternNotDefined
	 */
	public function test_should_throw_exception_on_empty_pattern()
	{
		Hooks::synthesize_routes_config([

			[
				'one' => [

					'controller' => function() {}

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

					'pattern' => '/'

				]

			]

		]);
	}

	public function test_should_not_throw_exception_on_empty_controller_if_location_is_defined()
	{
		$fragment = [

			'one' => [

				'pattern' => '/',
				'location' => '/en/'

			]

		];

		$config = Hooks::synthesize_routes_config([ $fragment ]);

		$this->assertEquals($fragment, $config);
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
		/* @var $app Application */
		$app = \ICanBoogie\app();
		$routes = Hooks::get_routes($app);
		$this->assertInstanceOf(RouteCollection::class, $routes);
		$this->assertSame($routes, Hooks::get_routes($app));
		$this->assertSame($routes, $app->routes);
	}
}
