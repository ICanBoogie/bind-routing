<?php

namespace Test\ICanBoogie\Binding\Routing;

use ICanBoogie\Binding\Routing\MiddlewareCompilerPass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Test\ICanBoogie\Binding\Routing\Acme\ProbeMiddleware;

final class MiddlewareCompilerPassTest extends TestCase
{
    public function test_autoconfigured_middleware_is_tagged(): void
    {
        $container = $this->make_container();
        $container->register(ProbeMiddleware::class)->setPublic(true)->setAutoconfigured(true);
        $container->compile();

        $actual = $container->getDefinition(ProbeMiddleware::class)->getTag(MiddlewareCompilerPass::TAG);

        $this->assertCount(1, $actual);
    }

    /**
     * The pass is processed before the container is compiled, as `ContainerFactory` does, otherwise the
     * autoconfiguration rule is registered after the instanceof conditionals have been resolved.
     */
    private function make_container(): ContainerBuilder
    {
        $container = new ContainerBuilder();
        (new MiddlewareCompilerPass())->process($container);

        return $container;
    }
}
