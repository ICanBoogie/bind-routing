<?php

namespace ICanBoogie\Binding\Routing;

use ICanBoogie\HTTP\RequestMethod;

use ICanBoogie\Routing\RouteMaker;
use RuntimeException;

use function ICanBoogie\hyphenate;
use function ICanBoogie\pluralize;
use function in_array;
use function strlen;
use function strrpos;
use function strtolower;
use function substr;

final class ActionResolver
{
    private const CONTROLLER_SUFFIX = 'Controller';
    private const ACTIONS = [

        RouteMaker::ACTION_LIST,
        RouteMaker::ACTION_NEW,
        RouteMaker::ACTION_CREATE,
        RouteMaker::ACTION_SHOW,
        RouteMaker::ACTION_EDIT,
        RouteMaker::ACTION_UPDATE,
        RouteMaker::ACTION_DELETE,

    ];

    /**
     * @param class-string $class
     */
    public static function resolve_action(string $class, string $method): string
    {
        $name = self::extract_action_name($method);

        if (!$name) {
            throw new RuntimeException("Unable to resolve action name from $class::$method");
        }

        $unqualified_class = substr($class, strrpos($class, '\\') + 1);

        if (str_ends_with($unqualified_class, self::CONTROLLER_SUFFIX)) {
            $unqualified_class = substr($unqualified_class, 0, -strlen(self::CONTROLLER_SUFFIX));
        }

        $base = pluralize(hyphenate($unqualified_class));

        return "$base:$name";
    }

    private static function extract_action_name(string $method): string
    {
        if (in_array($method, self::ACTIONS)) {
            return $method;
        }

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
