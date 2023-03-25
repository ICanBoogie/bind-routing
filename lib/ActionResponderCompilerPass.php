<?php

namespace ICanBoogie\Binding\Routing;

use ICanBoogie\Binding\Routing\Attribute\ActionResponder;
use ICanBoogie\Binding\Routing\Attribute\Route;
use olvlvl\ComposerAttributeCollector\Attributes;
use olvlvl\ComposerAttributeCollector\TargetMethod;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

use function array_fill_keys;
use function array_keys;
use function class_exists;
use function ICanBoogie\iterable_to_groups;
use function in_array;

/**
 * Registers controller services, and set the tags 'action_responder' and 'action_alias' according to attributes.
 */
final class ActionResponderCompilerPass implements CompilerPassInterface
{
    public const TAG = 'action_responder';

    public function process(ContainerBuilder $container): void
    {
        if (!class_exists(Attributes::class)) {
            return;
        }

        $target_methods_by_class = $this->find_target_methods_by_class();
        $this->process_controllers($container, $target_methods_by_class);
    }

    /**
     * @return array<class-string, iterable<TargetMethod<Route>>>
     */
    private function find_target_methods_by_class(): array
    {
        /** @phpstan-ignore-next-line */
        return iterable_to_groups(
            Attributes::filterTargetMethods(
                Attributes::predicateForAttributeInstanceOf(Route::class)
            ),
            fn(TargetMethod $t) => $t->class
        );
    }

    /**
     * Registers controllers with the class attributes {@link Route} or {@link ActionResponder}.
     *
     * @param array<class-string, iterable<TargetMethod<Route>>> $target_methods_by_class
     */
    private function process_controllers(ContainerBuilder $container, array $target_methods_by_class): void
    {
        foreach ($this->find_controllers_classes(array_keys($target_methods_by_class)) as $class) {
            $definition = $this->ensure_definition($class, $container);

            if (!$definition->hasTag(self::TAG)) {
                $definition->addTag(self::TAG);
            }

            $this->tag_aliases($definition, $target_methods_by_class[$class] ?? []);
        }
    }

    /**
     * @param iterable<TargetMethod<Route>> $target_methods
     */
    private function tag_aliases(Definition $definition, iterable $target_methods): void
    {
        foreach ($target_methods as $tm) {
            $action = $tm->attribute->action
                ?? ActionResolver::resolve_action($tm->class, $tm->name);

            $definition->addTag(ActionAliasCompilerPass::TAG, [ ActionAliasCompilerPass::TAG_KEY => $action ]);
        }
    }

    /**
     * Ensures the controller service is defined.
     *
     * @param class-string $class
     */
    private function ensure_definition(string $class, ContainerBuilder $container): Definition
    {
        if ($container->hasDefinition($class)) {
            return $container->getDefinition($class);
        }

        $definition = new Definition($class);
        $definition->setAutowired(true);
        $definition->setShared(false);

        $container->setDefinition($class, $definition);

        return $definition;
    }

    /**
     * @param array<class-string> $classes
     *     Classes already found from target methods.
     *
     * @return array<class-string>
     */
    private function find_controllers_classes(array $classes): array
    {
        $classes = array_fill_keys($classes, true);

        $target_classes = Attributes::filterTargetClasses(
            fn(string $attribute): bool => in_array($attribute, [ Route::class, ActionResponder::class ])
        );

        foreach ($target_classes as $target_class) {
            $classes[$target_class->name] = true;
        }

        return array_keys($classes);
    }
}
