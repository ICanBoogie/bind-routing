<?php

namespace ICanBoogie\Binding\Routing;

use ICanBoogie\Routing\ActionResponderProvider;
use ICanBoogie\Routing\ActionResponderProvider\Chain;
use ICanBoogie\Routing\ActionResponderProvider\FromConfig;
use ICanBoogie\Routing\ActionResponderProvider\WithMiddleware;
use ICanBoogie\Routing\Config;
use ICanBoogie\Routing\MiddlewareCollection;
use ICanBoogie\Routing\RouteProvider;
use LogicException;
use Psr\Container\ContainerInterface;

use function is_object;

/**
 * Creates services from the routing {@see Config}.
 */
final class ServiceFactory
{
    public static function route_provider(Config $config): RouteProvider
    {
        return $config->routes;
    }

    /**
     * @param ContainerInterface $controllers
     *     Provides the controllers of the config, see {@see ControllerCompilerPass}.
     * @param ActionResponderProvider $legacy
     *     Provides the responders of the controllers tagged with `action_responder`.
     * @param MiddlewareCollection $middleware
     *     Wraps the responders, see {@see MiddlewareCompilerPass}.
     */
    public static function action_responder_provider(
        Config $config,
        ContainerInterface $controllers,
        ActionResponderProvider $legacy,
        MiddlewareCollection $middleware,
    ): ActionResponderProvider {
        return new WithMiddleware(
            new Chain(
                new FromConfig($config, function (string $class) use ($controllers): object {
                    $controller = $controllers->get($class);

                    return is_object($controller)
                        ? $controller
                        : throw new LogicException("Unable to obtain controller: $class");
                }),
                $legacy
            ),
            $middleware
        );
    }
}
