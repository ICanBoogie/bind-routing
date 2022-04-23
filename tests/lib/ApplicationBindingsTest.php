<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Test\ICanBoogie\Binding\Routing;

use ICanBoogie\Routing\RouteProvider;
use PHPUnit\Framework\TestCase;

use function ICanBoogie\app;

final class ApplicationBindingsTest extends TestCase
{
    public function test_get_routes(): void
    {
        $this->assertInstanceOf(RouteProvider\Immutable::class, app()->routes);
    }
}
