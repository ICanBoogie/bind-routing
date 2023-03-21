<?php

namespace ICanBoogie\Binding\Routing;

use ICanBoogie\HTTP\RequestMethod;
use olvlvl\ComposerAttributeCollector\Attributes;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use function class_exists;
use function ICanBoogie\hyphenate;
use function ICanBoogie\pluralize;
use function str_ends_with;
use function str_starts_with;
use function strlen;
use function strrpos;
use function strtolower;
use function substr;

final class AttributeCompilerPass implements CompilerPassInterface
{
    private const TAG_ACTION_RESPONDER = 'action_responder';
    private const CONTROLLER_SUFFIX = 'Controller';

    public function process(ContainerBuilder $container): void
    {
        if (!class_exists(Attributes::class)) {
            return;
        }

        $this->process_action_responders($container);
        $this->process_actions($container);
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
     * Configures tag `{ name: action_alias, action: X }` from methods with the attribute {@link Action}.
     */
    private function process_actions(ContainerBuilder $container): void
    {
        $target_methods = Attributes::findTargetMethods(Action::class);

        foreach ($target_methods as $method) {
            $class = $method->class;
            $attribute = $method->attribute;
            $action = $attribute->action ?? $this->resolve_action($class, $method->name);

            $definition = $container->findDefinition($class);
            $definition->addTag(ActionAliasCompilerPass::TAG, [ ActionAliasCompilerPass::TAG_KEY => $action ]);
        }
    }

    /**
     * @param class-string $class
     */
    private function resolve_action(string $class, string $method): string
    {
        $name = $this->extract_action_name($method);
        $unqualified_class = substr($class, strrpos($class, '\\') + 1);

        if (str_ends_with($unqualified_class, self::CONTROLLER_SUFFIX)) {
            $unqualified_class = substr($unqualified_class, 0, -strlen(self::CONTROLLER_SUFFIX));
        }

        $base = pluralize(hyphenate($unqualified_class));

        return "$base:$name";
    }

    private function extract_action_name(string $method): string
    {
        foreach (RequestMethod::cases() as $case) {
            $try = strtolower($case->value) . '_';

            if (str_starts_with($try, $method)) {
                $method = substr($method, strlen($try));

                break;
            }
        }

        return $method;
    }
}
