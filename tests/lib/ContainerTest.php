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

final class ContainerTest extends TestCase
{
    public function test_service(): void
    {
        $actual = app()->container->get('test.route_provider');

        $this->assertInstanceOf(RouteProvider\Memoize::class, $actual);
    }

    public function test_parameter(): void
    {
        $param = 'routing.action_responder.aliases';
        $actual = app()->container->get('service_container')->getParameter($param);

        $this->assertEquals([
            'articles:home' => 'controller.article',
            'articles:show' => 'controller.article',
            'page:about' => 'controller.page',
            'api:ping' => 'ICanBoogie\Routing\PingController',
        ], $actual);
    }
}
