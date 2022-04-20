# bind-routing

[![Release](https://img.shields.io/packagist/v/icanboogie/bind-routing.svg)](https://packagist.org/packages/icanboogie/bind-routing)
[![Build Status](https://img.shields.io/github/workflow/status/ICanBoogie/bind-routing/test)](https://github.com/ICanBoogie/bind-routing/actions?query=workflow%3Atest)
[![Code Quality](https://img.shields.io/scrutinizer/g/ICanBoogie/bind-routing.svg)](https://scrutinizer-ci.com/g/ICanBoogie/bind-routing)
[![Code Coverage](https://img.shields.io/coveralls/ICanBoogie/bind-routing.svg)](https://coveralls.io/r/ICanBoogie/bind-routing)
[![Packagist](https://img.shields.io/packagist/dt/icanboogie/bind-routing.svg)](https://packagist.org/packages/icanboogie/bind-routing)

The **icanboogie/bind-routing** package binds [icanboogie/routing][] to [ICanBoogie][].

The package adds the getter `routes` to the [Application][] instance, a `url_for()` method that
creates URLs, and a synthesizer for the `routes` configuration fragments.

```php
<?php

namespace ICanBoogie;

require 'vendor/autoload.php';

$app = boot();

echo $app->url_for('articles:show', $app->models['articles']->one);
```





## Defining routes using configuration fragments

The most efficient way to define routes is through `routes` configuration fragments.

The following example demonstrates how to define routes, resource routes. The pattern of the
`articles:show` route is overridden to use _year_, _month_ and _slug_.

```php
<?php

// config/routes.php

namespace App;

use ICanBoogie\Binding\Routing\ConfigBuilder;
use ICanBoogie\Routing\RouteMaker;

return function (ConfigBuilder $config): void {
    $config->route('/', 'page:home')
    $config->resource('articles', new Make\Options(
        basics: [
            RouteMaker::ACTION_SHOW => new Make\Basics('/articles/:year-:month-:slug.html')
        ]
    ))
};
```

The following code demonstrates how to obtain a route collection from the `routes` configuration:

```php
<?php

$routes = $app->configs['routes'];
```



----------



## Installation

```bash
composer require icanboogie/bind-routing
```



## Testing

Run `make test-container` to create and log into the test container, then run `make test` to run the
test suite. Alternatively, run `make test-coverage` to run the test suite with test coverage. Open
`build/coverage/index.html` to see the breakdown of the code coverage.



## License

**icanboogie/bind-routing** is released under the [New BSD License](LICENSE).



[icanboogie/icanboogie]:       https://github.com/ICanBoogie/ICanBoogie
[icanboogie/routing]:          https://github.com/ICanBoogie/Routing
[ICanBoogie]:                  https://github.com/ICanBoogie/ICanBoogie
[Application]:                 https://icanboogie.org/docs/4.0/the-application-class
