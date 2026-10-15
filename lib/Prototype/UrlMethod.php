<?php

namespace ICanBoogie\Binding\Routing\Prototype;

use ICanBoogie\Prototype\ConfigBuilder;
use ICanBoogie\Routing\ActionResolver;
use ICanBoogie\Routing\Route;
use ICanBoogie\Routing\RouteMaker;
use ICanBoogie\Routing\UrlGenerator;
use olvlvl\ComposerAttributeCollector\Attributes;
use RuntimeException;

use function ICanBoogie\Service\ref;

final class UrlMethod
{
    public const string METHOD = 'url';

    /**
     * Automatically binds the 'url' method using attributes.
     */
    public static function bind(ConfigBuilder $config): ConfigBuilder
    {
        class_exists(Attributes::class)
        or throw new RuntimeException(
            sprintf(
                "The class '%s' is not available, is the package '%s' installed?",
                Attributes::class,
                'olvlvl/composer-attribute-collector'
            )
        );

        $targets = Attributes::findTargetMethods(UrlGetter::class);

        foreach ($targets as $target) {
            $config->bind($target->class, self::METHOD, ref(self::class));
        }

        return $config;
    }

    public function __construct(
        private readonly UrlGenerator $generator
    ) {
    }

    /**
     * @param non-empty-string $unqualified_action
     * @param array<string, mixed>|object|null $query_params
     *     Parameters for the query string.
     */
    public function __invoke(
        object $caller,
        string $unqualified_action = RouteMaker::ACTION_SHOW,
        array|object|null $query_params = null,
    ): string {
        $action = $this->resolve_action($caller, $unqualified_action);

        return $this->generator->generate_url($action, $caller, $query_params);
    }

    /**
     * @param non-empty-string $unqualified_action
     *
     * @return non-empty-string
     */
    private function resolve_action(object $caller, string $unqualified_action): string
    {
        static $cache = [];

        $key = $caller::class . Route::ACTION_SEPARATOR . $unqualified_action;

        // @phpstan-ignore-next-line
        return $cache[$key] ??= self::make_action($caller, $unqualified_action);
    }

    /**
     * The action is inferred the way the routing does for controllers, the model `Article` is
     * `article:show`.
     *
     * @param non-empty-string $unqualified_action
     *
     * @return non-empty-string
     */
    private function make_action(object $caller, string $unqualified_action): string
    {
        return ActionResolver::resolve($caller::class, $unqualified_action);
    }
}
