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

use ICanBoogie\Core;

$loader = require __DIR__ . '/../vendor/autoload.php';
$loader->addPsr4('ICanBoogie\\Binding\\Routing\\ControllerTest\\', __DIR__ . '/ControllerTest');

class Application extends Core
{
	use CoreBindings;
}

(new Application(\ICanBoogie\get_autoconfig()))->boot();
