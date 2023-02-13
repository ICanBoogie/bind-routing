<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Binding\Routing\Prototype;

use ICanBoogie\Routing\Route;
use ICanBoogie\Routing\RouteMaker;
use ICanBoogie\Routing\UrlGenerator;

use function basename;
use function ICanBoogie\pluralize;
use function ICanBoogie\underscore;

final class UrlMethod
{
    public const METHOD = 'url';

    public function __construct(
        private readonly UrlGenerator $generator
    ) {
    }

    /**
     * @param array<string, mixed>|object|null $query_params
     *     Parameters for the query string.
     */
    public function __invoke(
        object $caller,
        string $unqualified_action = RouteMaker::ACTION_SHOW,
        array|object|null $query_params = null,
    ): string {
        $action = $this->resolve_action($caller, $unqualified_action);

        return $this->generator->generate_url($action, $caller, $query_params);
    }

    private function resolve_action(object $caller, string $unqualified_action): string
    {
        static $cache = [];

        $key = $caller::class . Route::ACTION_SEPARATOR . $unqualified_action;

        return $cache[$key] ??= self::make_action($caller, $unqualified_action);
    }

    private function make_action(object $caller, string $unqualified_action): string
    {
        $base = basename(underscore($caller::class));

        return pluralize($base) . Route::ACTION_SEPARATOR . $unqualified_action;
    }
}
