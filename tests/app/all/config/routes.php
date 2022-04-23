<?php

use ICanBoogie\Binding\Routing\ConfigBuilder;

return fn(ConfigBuilder $config) => $config
    ->route('/', 'home')
    ->resource('articles');
