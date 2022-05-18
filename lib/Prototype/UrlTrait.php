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

use ICanBoogie\Routing\RouteMaker;

/**
 * @method string url(string $unqualified_action = RouteMaker::ACTION_SHOW, array|object|null $query_params = null)
 *
 * @property-read string $url
 */
trait UrlTrait
{
    protected function get_url(): string
    {
        return $this->url();
    }
}
