<?php

namespace ICanBoogie\Binding\Routing;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Creates a mapping of action to alias, which is used to forward multiple actions to the same responder.
 */
final class ActionAliasCompilerPass implements CompilerPassInterface
{
    public const string PARAM = 'routing.action_responder.aliases';
    public const string TAG = 'action_alias';
    public const string TAG_KEY = 'action';

    public function process(ContainerBuilder $container): void
    {
        $this->process_action_alias($container);
    }

    private function process_action_alias(ContainerBuilder $container): void
    {
        /**
         * @var array<string, string> $aliases
         *     Where _key_ is an action and _value_ an alias
         */
        $aliases = [];

        foreach ($container->findTaggedServiceIds(self::TAG) as $id => $tags) {
            foreach ($tags as $tag) {
                // @phpstan-ignore-next-line
                $aliases[$tag[self::TAG_KEY]] = $id;
            }
        }

        $container->setParameter(self::PARAM, $aliases);
    }
}
