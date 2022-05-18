<?php

use App\Modules\Articles\ArticleController;
use ICanBoogie\Binding\Routing\ConfigBuilder;
use ICanBoogie\HTTP\RequestMethod;
use ICanBoogie\Routing\RouteMaker as Make;

return fn(ConfigBuilder $config) => $config
    ->route('/', 'home')
    ->resource('articles',
        options: new Make\Options(
            id_name: 'article_id',
            basics: [

                Make::ACTION_LIST => new Make\Basics('/articles', RequestMethod::METHOD_GET),
                Make::ACTION_SHOW => new Make\Basics('/articles/<year:\d{4}>-<month:\d{2}>-:slug', RequestMethod::METHOD_GET),

            ]
        )
    );
