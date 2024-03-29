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
use Test\ICanBoogie\Binding\Routing\Acme\ImageController;
use Test\ICanBoogie\Binding\Routing\Acme\PageController;
use Test\ICanBoogie\Binding\Routing\Acme\SkillController;

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
    public static function provide_service(): array
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
            'articles:list' => ArticleController::class,
            'articles:show' => ArticleController::class,
            'articles:create' => ArticleController::class,
            'images:list' => ImageController::class,
            'images:show' => ImageController::class,
            'images:create' => ImageController::class,
            'images:update' => ImageController::class,
            'images:delete' => ImageController::class,
            'skills:list' => SkillController::class,
            'skills:show' => SkillController::class,
            'skills:create' => SkillController::class,
            'skills:update' => SkillController::class,
            'skills:delete' => SkillController::class,
            'pages:about' => PageController::class,
            'api:ping' => PingController::class,
        ], $actual);
    }

    /**
     * @dataProvider provide_responder_provider
     *
     * @param class-string $expected_class
     */
    public function test_responder_provider(string $action, string $expected_class): void
    {
        $responder_provider = app()->service_for_id('test.action_responder_provider', ActionResponderProvider::class);
        $responder = $responder_provider->responder_for_action($action);

        $this->assertInstanceOf($expected_class, $responder);
    }

    /**
     * @return array<array{ string, class-string }>
     */
    public static function provide_responder_provider(): array
    {
        return [

            [ 'articles:list', ArticleController::class ],
            [ 'articles:show', ArticleController::class ],
            [ 'articles:create', ArticleController::class ],
            [ 'pages:about', PageController::class ],
            [ 'images:list', ImageController::class ],
            [ 'images:show', ImageController::class ],
            [ 'skills:show', SkillController::class ],
            [ 'skills:create', SkillController::class ],

        ];
    }
}
