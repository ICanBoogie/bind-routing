<?php

namespace Test\ICanBoogie\Binding\Routing;

use ICanBoogie\Binding\Routing\ConfigBuilder;
use ICanBoogie\Routing\CacheStrategy;
use ICanBoogie\Routing\RouteProvider\Compiled;
use PHPUnit\Framework\TestCase;

final class ConfigBuilderTest extends TestCase
{
    public function test_fragment_filename(): void
    {
        $this->assertSame('routes', ConfigBuilder::get_fragment_filename());
    }

    public function test_cache_strategy(): void
    {
        $config = new ConfigBuilder()
            ->discover_controllers()
            ->cache_strategy(CacheStrategy::COMPILE)
            ->build();

        $this->assertInstanceOf(Compiled::class, $config->routes);
    }
}
