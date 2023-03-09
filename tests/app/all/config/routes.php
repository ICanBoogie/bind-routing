<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use ICanBoogie\Binding\Routing\ConfigBuilder;
use ICanBoogie\HTTP\RequestMethod;
use ICanBoogie\Routing\RouteMaker as Make;

return fn(ConfigBuilder $config) => $config
    ->route('/', 'home')
    ->get('/dance-sessions/:slug.html', 'dance-sessions:show')
    ->resource(
        'articles',
        options: new Make\Options(
            id_name: 'article_id',
            basics: [

                Make::ACTION_LIST => new Make\Basics('/articles', RequestMethod::METHOD_GET),
                Make::ACTION_SHOW => new Make\Basics(
                    '/articles/<year:\d{4}>-<month:\d{2}>-:slug',
                    RequestMethod::METHOD_GET
                ),

            ]
        )
    );
