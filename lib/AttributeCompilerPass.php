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
use olvlvl\ComposerAttributeCollector\Attributes;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use function class_exists;

final class AttributeCompilerPass implements CompilerPassInterface
{
    private const TAG_ACTION_RESPONDER = 'action_responder';

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
            $definition->addTag(self::TAG_ACTION_RESPONDER);
        }
    }

    /**
     * Configures tag `{ name: action_alias, action: X }` from methods with the attribute _route_ attributes.
     */
    private function process_routes(ContainerBuilder $container): void
    {
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
            $class = $method->class;
            $attribute = $method->attribute;
            $action = $attribute->action ?? ActionResolver::resolve_action($class, $method->name);

            $definition = $container->findDefinition($class);
            $definition->addTag(ActionAliasCompilerPass::TAG, [ ActionAliasCompilerPass::TAG_KEY => $action ]);
        }
    }
}
