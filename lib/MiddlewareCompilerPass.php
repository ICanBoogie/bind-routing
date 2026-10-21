<?php

namespace ICanBoogie\Binding\Routing;

use ICanBoogie\Routing\Middleware;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Tags the services implementing {@see Middleware} with `routing.middleware`, when they are
 * registered with `autoconfigure: true`. The tagged services are collected by the
 * `MiddlewareCollection` service, which wraps the responders, see
 * `ServiceFactory::action_responder_provider()`.
 *
 * A service registered without `autoconfigure` must be tagged by hand.
 */
final class MiddlewareCompilerPass implements CompilerPassInterface
{
    public const string TAG = 'routing.middleware';

    public function process(ContainerBuilder $container): void
    {
        $container->registerForAutoconfiguration(Middleware::class)->addTag(self::TAG);
    }
}
