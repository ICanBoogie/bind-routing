<?php

namespace ICanBoogie\Binding\Routing;

use ICanBoogie\Binding\Routing\Attribute\Connect;
use ICanBoogie\Binding\Routing\Attribute\Delete;
use ICanBoogie\Binding\Routing\Attribute\Get;
use ICanBoogie\Binding\Routing\Attribute\Head;
use ICanBoogie\Binding\Routing\Attribute\Options;
use ICanBoogie\Binding\Routing\Attribute\Patch;
use ICanBoogie\Binding\Routing\Attribute\Post;
use ICanBoogie\Binding\Routing\Attribute\Put;
use ICanBoogie\Binding\Routing\Attribute\Route;
use ICanBoogie\Binding\Routing\Attribute\Trace;
use ICanBoogie\Config\Builder;
use ICanBoogie\Routing\RouteCollector;
use ICanBoogie\Routing\RouteProvider;
use LogicException;
use olvlvl\ComposerAttributeCollector\Attributes;
use olvlvl\ComposerAttributeCollector\TargetMethod;

use function class_exists;
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

        /** @var TargetMethod<Route>[] $target_methods */
        $target_methods = [
            ...Attributes::findTargetMethods(Get::class),
            ...Attributes::findTargetMethods(Head::class),
            ...Attributes::findTargetMethods(Post::class),
            ...Attributes::findTargetMethods(Put::class),
            ...Attributes::findTargetMethods(Delete::class),
            ...Attributes::findTargetMethods(Connect::class),
            ...Attributes::findTargetMethods(Options::class),
            ...Attributes::findTargetMethods(Trace::class),
            ...Attributes::findTargetMethods(Patch::class),
            ...Attributes::findTargetMethods(Route::class),
        ];

        foreach ($target_methods as $method) {
            $prefix = $route_by_class[$method->class]->pattern ?? '';

            $attribute = $method->attribute;
            $pattern = $prefix . $attribute->pattern;
            $action = $attribute->action
                ?? ActionResolver::resolve_action($method->class, $method->name);

            $this->route(
                pattern: $pattern,
                action:  $action,
                methods:  $attribute->methods,
                id:  $attribute->id
            );
        }

        return $this;
    }

    /**
     * @return array<class-string, Route>
     */
    private function build_route_by_class(): array
    {
        $by_class = [];

        foreach (Attributes::findTargetClasses(Route::class) as $target_class) {
            $by_class[$target_class->name] = $target_class->attribute;
        }

        return $by_class;
    }
}
