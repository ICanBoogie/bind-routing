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

use function ICanBoogie\app;

class ApplicationBindingsTest extends \PHPUnit\Framework\TestCase
{
	/**
	 * @var Application
	 */
	static private $app;

	static public function setupBeforeClass(): void
	{
		self::$app = app();
	}

	public function test_get_routes()
	{
		$this->assertInstanceOf(RouteCollection::class, self::$app->routes);
	}
}
