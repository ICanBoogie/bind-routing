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
use ICanBoogie\Routing\RouteCollection;
use ICanBoogie\Routing\RouteDispatcher;

class RoutingDispatcherConstructorTest extends \PHPUnit\Framework\TestCase
{
	public function test_construct()
	{
		$app = $this->mockApp();
		$constructor = new RouteDispatcherConstructor($app);
		$dispatcher = $constructor([]);

		$this->assertInstanceOf(RouteDispatcher::class, $dispatcher);
	}

	/**
	 * @return Application
	 */
	private function mockApp()
	{
		$app = $this->getMockBuilder(Application::class)
			->disableOriginalConstructor()
			->setMethods([ 'get_routes' ])
			->getMock();
		$app
			->expects($this->once())
			->method('get_routes')
			->willReturn(new RouteCollection);

		return $app;
	}
}
