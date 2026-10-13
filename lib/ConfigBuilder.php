<?php

namespace ICanBoogie\Binding\Routing;

use Closure;
use ICanBoogie\Config\Builder;
use ICanBoogie\Routing\CacheStrategy;
use ICanBoogie\Routing\Config;
use ICanBoogie\Routing\ConfigBuilder as RoutingConfigBuilder;
use ICanBoogie\Routing\Exception\ConfigNotValid;
use ICanBoogie\Routing\RouteBuilder;
use LogicException;

/**
 * A config builder for 'routes' fragments.
 *
 * It wraps {@see RoutingConfigBuilder} to make it a config builder. The cache strategy is up to the configuration
 * file: use {@see CacheStrategy::COMPILE} in production, the configuration is cached as a PHP file, so the work is
 * done once, when the configuration is built, and not by every request, and {@see CacheStrategy::MEMOIZE} in
 * development.
 *
 * @implements Builder<Config>
 */
final readonly class ConfigBuilder implements Builder
{
    public static function get_fragment_filename(): string
    {
        return 'routes';
    }

    private RoutingConfigBuilder $builder;

    public function __construct()
    {
        $this->builder = new RoutingConfigBuilder();
    }

    public function build(): Config
    {
        return $this->builder->build();
    }

    /**
     * @param class-string $controller
     * @param (Closure(RouteBuilder): mixed)|null $route_builder
     *
     * @return $this
     *
     * @throws ConfigNotValid
     *
     * @see RoutingConfigBuilder::add_controller()
     */
    public function add_controller(string $controller, ?Closure $route_builder = null): self
    {
        $this->builder->add_controller($controller, $route_builder);

        return $this;
    }

    /**
     * @return $this
     *
     * @throws ConfigNotValid
     * @throws LogicException if the attribute collector is not available.
     *
     * @see RoutingConfigBuilder::discover_controllers()
     */
    public function discover_controllers(): self
    {
        $this->builder->discover_controllers();

        return $this;
    }

    /**
     * @return $this
     *
     * @see RoutingConfigBuilder::cache_strategy()
     */
    public function cache_strategy(CacheStrategy $strategy): self
    {
        $this->builder->cache_strategy($strategy);

        return $this;
    }
}
