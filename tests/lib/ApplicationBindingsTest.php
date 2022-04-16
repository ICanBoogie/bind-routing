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
use PHPUnit\Framework\TestCase;
use function ICanBoogie\app;

final class ApplicationBindingsTest extends TestCase
{
	static private Application $app;

	static public function setUpBeforeClass(): void
	{
		parent::setUpBeforeClass();

		self::$app = app();
	}

	public function test_get_routes()
	{
		$this->assertInstanceOf(RouteCollection::class, self::$app->routes);
	}
}
