<?php

namespace ICanBoogie\Binding\Routing;

use ICanBoogie\Binding\Routing\Attribute\Route;
use ICanBoogie\Config\Builder;
use ICanBoogie\Routing\RouteCollector;
use ICanBoogie\Routing\RouteProvider;
use LogicException;
use olvlvl\ComposerAttributeCollector\Attributes;
use olvlvl\ComposerAttributeCollector\TargetClass;
use olvlvl\ComposerAttributeCollector\TargetMethod;

use function class_exists;
use function ICanBoogie\iterable_to_dictionary;
use function sprintf;

/**
 * A config builder for 'routes' fragments.
 *
 * @implements Builder<RouteProvider>
 */
final class ConfigBuilder extends RouteCollector implements Builder
{
    public static function get_fragment_filename(): string
    {
        return 'routes';
    }

    public function build(): RouteProvider
    {
        return $this->collect();
    }

    /**
     * Builds configuration from the {@link Route} attribute.
     *
     * @return $this
     */
    public function from_attributes(): self
    {
        if (!class_exists(Attributes::class)) {
            throw new LogicException(
                sprintf(
                    "Unable to build from attributes, the class %s is not available",
                    Attributes::class
                )
            );
        }

        $route_by_class = $this->build_route_by_class();
        $target_methods = $this->get_target_methods();

        foreach ($target_methods as $method) {
            $prefix = $route_by_class[$method->class]->pattern ?? '';

            $attribute = $method->attribute;
            $pattern = $prefix . $attribute->pattern;
            $action = $attribute->action
                ?? ActionResolver::resolve_action($method->class, $method->name);

            $this->route(
                pattern: $pattern,
                action: $action,
                methods: $attribute->methods,
                id: $attribute->id
            );
        }

        return $this;
    }

    /**
     * @return array<TargetMethod<Route>>
     */
    private function get_target_methods(): array
    {
        /** @phpstan-ignore-next-line */
        return Attributes::filterTargetMethods(
            Attributes::predicateForAttributeInstanceOf(Route::class)
        );
    }

    /**
     * @return array<class-string, Route>
     */
    private function build_route_by_class(): array
    {
        return iterable_to_dictionary(
            Attributes::findTargetClasses(Route::class),
            fn(TargetClass $t): string => $t->name,
            fn(TargetClass $t): Route => $t->attribute,
        );
    }
}
