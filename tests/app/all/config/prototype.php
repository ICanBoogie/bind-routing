<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie;

use ICanBoogie\Binding\Prototype\ConfigBuilder;
use ICanBoogie\Binding\Routing\Prototype\UrlMethod;
use Test\ICanBoogie\Binding\Routing\Acme\Article;
use Test\ICanBoogie\Binding\Routing\Acme\DanceSession;

use function ICanBoogie\Service\ref;

return fn(ConfigBuilder $config) => $config
    ->bind(Article::class, UrlMethod::METHOD, ref(UrlMethod::class))
    ->bind(DanceSession::class, UrlMethod::METHOD, ref(UrlMethod::class));
