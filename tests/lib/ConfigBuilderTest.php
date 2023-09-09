<?php

namespace Test\ICanBoogie\Binding\Routing;

use ICanBoogie\Binding\Routing\ConfigBuilder;
use ICanBoogie\HTTP\RequestMethod;
use ICanBoogie\Routing\Route;
use ICanBoogie\Routing\RouteProvider\ByAction;
use PHPUnit\Framework\TestCase;

final class ConfigBuilderTest extends TestCase
{
    public function test_from_route_attribute(): void
    {
        $config = (new ConfigBuilder())
            ->use_attributes()
            ->build();

        $route_for_action = fn(string $action)
        => $config->route_for_predicate(new ByAction($action));

        $expected = [

            'images:list' => new Route('/images.html', 'images:list', methods: RequestMethod::METHOD_GET),
            'images:show' => new Route('/images/:id.html', 'images:show', methods: RequestMethod::METHOD_GET),
            'images:create' => new Route('/images', 'images:create', methods: RequestMethod::METHOD_POST),
            'images:update' => new Route('/images/:id', 'images:update', methods: RequestMethod::METHOD_PUT),
            'images:delete' => new Route('/images/:id', 'images:delete', methods: RequestMethod::METHOD_DELETE),

            'skills:list' => new Route('/skills', 'skills:list', methods: RequestMethod::METHOD_GET),
            'skills:show' => new Route('/skills/:slug.html', 'skills:show', methods: RequestMethod::METHOD_GET),
            'skills:create' => new Route('/skills', 'skills:create', methods: RequestMethod::METHOD_POST),
            'skills:update' => new Route('/skills/:id', 'skills:update', methods: RequestMethod::METHOD_PUT),
            'skills:delete' => new Route('/skills/:id', 'skills:delete', methods: RequestMethod::METHOD_DELETE),

        ];

        foreach ($expected as $action => $exp) {
            $route = $route_for_action($action);

            $this->assertNotNull($route, "No match for action $action");
            $this->assertEquals($exp, $route);
        }
    }
}
