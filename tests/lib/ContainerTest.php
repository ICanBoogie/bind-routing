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

use ICanBoogie\Routing\ActionResponderProvider;
use ICanBoogie\Routing\PingController;
use ICanBoogie\Routing\RouteProvider;
use ICanBoogie\Routing\UrlGenerator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Test\ICanBoogie\Binding\Routing\Acme\ArticleController;

use Test\ICanBoogie\Binding\Routing\Acme\PageController;

use function ICanBoogie\app;

final class ContainerTest extends TestCase
{
    /**
     * @dataProvider provide_service
     *
     * @param class-string $class
     * @param class-string $concrete_class
     */
    public function test_service(string $id, string $class, string $concrete_class): void
    {
        $actual = app()->service_for_id($id, $class);

        $this->assertInstanceOf($concrete_class, $actual);
    }

    /**
     * @return array<array{ string, class-string }>
     */
    public function provide_service(): array
    {
        return [

            [ 'test.action_responder_provider', ActionResponderProvider::class, ActionResponderProvider\Container::class ],
            [ 'test.route_provider', RouteProvider::class, RouteProvider\Memoize::class ],
            [ 'test.url_generator', UrlGenerator::class, UrlGenerator\UrlGeneratorWithRouteProvider::class ],

        ];
    }

    public function test_parameter(): void
    {
        $param = 'routing.action_responder.aliases';
        $actual = app()->service_for_id('service_container', ContainerInterface::class)->getParameter($param);

        $this->assertEquals([
            'articles:home' => ArticleController::class,
            'articles:show' => ArticleController::class,
            'articles:create' => ArticleController::class,
            'page:about' => PageController::class,
            'api:ping' => PingController::class,
        ], $actual);
    }
}
