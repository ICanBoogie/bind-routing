<?php

namespace ICanBoogie\Binding\Routing;

use ICanBoogie\Binding\Routing\Attribute\ActionResponder;
use ICanBoogie\Binding\Routing\Attribute\Route;
use olvlvl\ComposerAttributeCollector\Attributes;
use olvlvl\ComposerAttributeCollector\TargetMethod;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use function array_keys;
use function class_exists;
use function is_a;

final class AttributeCompilerPass implements CompilerPassInterface
{
    public const TAG_ACTION_RESPONDER = 'action_responder';

    public function process(ContainerBuilder $container): void
    {
        if (!class_exists(Attributes::class)) {
            return;
        }

        $this->process_action_responders($container);
        $this->process_routes($container);
    }

    /**
     * Configures tag `{ name: action_responder }` from classes with the attribute {@link ActionResponder}.
     */
    private function process_action_responders(ContainerBuilder $container): void
    {
        $target_classes = Attributes::findTargetClasses(ActionResponder::class);

        foreach ($target_classes as $class) {
            $definition = $container->findDefinition($class->name);

            if (!$definition->hasTag(self::TAG_ACTION_RESPONDER)) {
                $definition->addTag(self::TAG_ACTION_RESPONDER);
            }
        }
    }

    /**
     * Configures tag `{ name: action_alias, action: X }` from methods with _route_ attributes.
     */
    private function process_routes(ContainerBuilder $container): void
    {
        $classes = [];

        foreach ($this->get_target_methods() as $method) {
            $class = $method->class;
            $classes[$class] = true;
            $attribute = $method->attribute;
            $action = $attribute->action ?? ActionResolver::resolve_action($class, $method->name);

            $definition = $container->findDefinition($class);
            $definition->addTag(ActionAliasCompilerPass::TAG, [ ActionAliasCompilerPass::TAG_KEY => $action ]);
        }

        // Add 'action_responder' tag to classes with _route_ attributes.

        foreach (array_keys($classes) as $class) {
            $definition = $container->findDefinition($class);

            if (!$definition->hasTag(self::TAG_ACTION_RESPONDER)) {
                $definition->addTag(self::TAG_ACTION_RESPONDER);
            }
        }
    }

    /**
     * @return array<TargetMethod<Route>>
     */
    private function get_target_methods(): array
    {
        /** @phpstan-ignore-next-line */
        return Attributes::filterTargetMethods(
            fn($attribute) => is_a($attribute, Route::class, true)
        );
    }
}
