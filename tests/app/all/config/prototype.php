<?php

namespace ICanBoogie;

use ICanBoogie\Binding\Prototype\ConfigBuilder;
use ICanBoogie\Binding\Routing\Prototype\UrlMethod;
use Test\ICanBoogie\Binding\Routing\Prototype\Article;

use function ICanBoogie\Service\ref;

return fn(ConfigBuilder $config) => $config
    ->bind(Article::class, UrlMethod::METHOD, ref(UrlMethod::class))
;
