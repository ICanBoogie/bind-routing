<?php

namespace ICanBoogie\Binding\Routing\Console;

use ICanBoogie\Routing\Config;

final readonly class HandlerResolver
{
    /**
     * @param array<string, string> $aliases
     */
    public static function resolve(string $action, Config $config, array $aliases): string
    {
        $controller = $config->controller_by_action[$action] ?? null;

        if ($controller) {
            return $controller . '::' . ($config->controllers[$controller]->actions[$action]->method ?? '<unknown>');
        }

        return $aliases[$action] ?? '';
    }
}
