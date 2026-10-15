<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use ICanBoogie\Routing\ConfigBuilder;
use ICanBoogie\Routing\CacheStrategy;

return fn(ConfigBuilder $config) => $config
    ->enable_discovery()
    ->cache_strategy(CacheStrategy::COMPILE);
