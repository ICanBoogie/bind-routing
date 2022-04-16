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

use ICanBoogie\Routing\RouteProvider;

use function var_dump;

chdir(__DIR__);

require __DIR__ . '/../vendor/autoload.php';

$app = boot();

//var_dump($app->container->get(RouteProvider::class));
