<?php

namespace ICanBoogie\Binding\Routing;

use ICanBoogie\Routing\Attribute\Route;
use olvlvl\ComposerAttributeCollector\Attributes;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

use function array_keys;
use function class_exists;

/**
 * Registers the controllers of the routing config as shared services tagged with `routing.controller`, which are
 * provided by a tagged locator, see `ServiceFactory::action_responder_provider()`.
 *
 * The controllers found through the {@see Route} attributes of their methods are registered, if they are not
 * already. A controller added without attributes, e.g. with a route builder, must be registered and tagged with
 * `routing.controller`.
 */
final class ControllerCompilerPass implements CompilerPassInterface
{
    public const string TAG = 'routing.controller';

    public function process(ContainerBuilder $container): void
    {
        foreach ($this->find_classes() as $class) {
            if (!$container->hasDefinition($class)) {
                $definition = new Definition($class);
                $definition->setAutowired(true);

                $container->setDefinition($class, $definition);
            }

            $container->getDefinition($class)->addTag(self::TAG);
        }
    }

    /**
     * @return iterable<class-string>
     */
    private function find_classes(): iterable
    {
        if (!class_exists(Attributes::class)) {
            return [];
        }

        $classes = [];
        $predicate = Attributes::filterTargetMethods(Attributes::predicateForAttributeInstanceOf(Route::class));

        foreach ($predicate as $target) {
            $classes[$target->class] = true;
        }

        return array_keys($classes);
    }
}
