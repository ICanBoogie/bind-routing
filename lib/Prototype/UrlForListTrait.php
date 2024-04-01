<?php

namespace ICanBoogie\Binding\Routing\Prototype;

use ICanBoogie\Routing\RouteMaker;

/**
 * @method string url(string $unqualified_action = RouteMaker::ACTION_SHOW, array|object|null $query_params = null)
 *
 * @property-read string $url_for_list
 */
trait UrlForListTrait
{
    #[UrlGetter]
    protected function get_url_for_list(): string
    {
        return $this->url(RouteMaker::ACTION_LIST);
    }
}
