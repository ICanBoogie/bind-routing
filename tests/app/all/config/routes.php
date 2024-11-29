<?php

use ICanBoogie\Binding\Routing\ConfigBuilder;

return fn(ConfigBuilder $config) => $config
    ->route('/', 'pages:home')
    ->get('/dance-sessions/:slug.html', 'dance-sessions:show')
    ->use_attributes();
