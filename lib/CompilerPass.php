<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Binding\Routing;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class CompilerPass implements CompilerPassInterface
{
	public const PARAM_ALIASES = 'routing.action_responder.aliases';
	public const TAG_ACTION_ALIAS = 'action_alias';
	public const KEY_ACTION = 'action';

	public function process(ContainerBuilder $container)
	{
		$this->process_action_alias($container);
	}

	/**
	 * Creates a mapping of action to alias.
	 */
	private function process_action_alias(ContainerBuilder $container): void
	{
		/**
		 * @var array<string, string>
		 *     Where _key_ is an action and _value_ an alias
		 */
		$aliases = [];

		foreach ($container->findTaggedServiceIds(self::TAG_ACTION_ALIAS) as $id => $tags) {
			foreach ($tags as $tag) {
				$aliases[$tag[self::KEY_ACTION]] = $id;
			}
		}

		$container->setParameter(self::PARAM_ALIASES, $aliases);
	}
}
