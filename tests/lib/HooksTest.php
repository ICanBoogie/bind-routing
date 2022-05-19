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

use ICanBoogie\Binding\Routing\Hooks;
use ICanBoogie\Routing\RouteProvider\ByUri;
use PHPUnit\Framework\TestCase;

use function ICanBoogie\app;
use function implode;

final class HooksTest extends TestCase
{
    public function test_get_routes(): void
    {
        $app = app();
        $routes = Hooks::get_routes($app);
        $this->assertSame($routes, Hooks::get_routes($app));
        $this->assertSame($routes, $app->routes);

        $this->assertSame(
            'home',
            $app->routes->route_for_predicate(new ByUri('/'))->action
        );

        $actions = [];

        foreach ($routes as $route) {
            $actions[] = $route->action;
        }

        $this->assertEquals(
            "api:ping home articles:list articles:new articles:create articles:show articles:edit articles:update articles:delete",
            implode(' ', $actions)
        );
    }
}
