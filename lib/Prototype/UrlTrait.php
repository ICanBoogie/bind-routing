<?php

namespace ICanBoogie\Binding\Routing\Prototype;

use ICanBoogie\Routing\RouteMaker;

/**
 * @method string url(string $unqualified_action = RouteMaker::ACTION_SHOW, mixed[]|object|null $query_params = null)
 *
 * @property-read string $url
 */
trait UrlTrait // @phpstan-ignore trait.unused
{
    #[UrlGetter]
    protected function get_url(): string
    {
        return $this->url();
    }
}
