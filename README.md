# bind-routing

[![Packagist](https://img.shields.io/packagist/v/icanboogie/bind-routing.svg)](https://packagist.org/packages/icanboogie/bind-routing)
[![Code Quality](https://img.shields.io/scrutinizer/g/ICanBoogie/bind-routing.svg)](https://scrutinizer-ci.com/g/ICanBoogie/bind-routing)
[![Code Coverage](https://img.shields.io/coveralls/ICanBoogie/bind-routing.svg)](https://coveralls.io/r/ICanBoogie/bind-routing)
[![Downloads](https://img.shields.io/packagist/dt/icanboogie/bind-routing.svg)](https://packagist.org/packages/icanboogie/bind-routing)

The **icanboogie/bind-routing** package binds [icanboogie/routing][] to [ICanBoogie][].



#### Installation

```bash
composer require icanboogie/bind-routing
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

return fn(ConfigBuilder $config) => $config
    ->route('/', 'page:home')
    ->resource('articles', new Make\Options(
        basics: [
            RouteMaker::ACTION_SHOW => new Make\Basics('/articles/:year-:month-:slug.html')
        ]
    ));
```

The following code demonstrates how to obtain a route collection from the `routes` configuration:

```php
<?php

namespace ICanBoogie;

/** @var Application $app */

$routes = $app->config_for_class(Routing\RouteProvider::class);
```

### Matching routes with controllers

Routes have no idea of the controller to use, to match a route with a controller, you need to tag
the controller with the actions that it supports.

The following example demonstrates how `ArticleControler` is configured to handle the actions
`articles:show` and `articles:list`.

```yaml
services:
  _defaults:
    autowire: true

  App\Presentation\HTTP\Controller\ArticleController:
      shared: false
      tags:
      - { name: action_responder }
      - { name: action_alias, action: 'articles:list' }
      - { name: action_alias, action: 'articles:show' }
```

Alternatively, you can add the `Action` attribute to your action methods:

```php
<?php

namespace App\Presentation\HTTP\Controller;

use ICanBoogie\Binding\Routing\Action;

final class ArticleController
{
    // ...

    #[Action]
    private function list(): void
    {
        // ...
    }

    #[Action]
    private function show(): void
    {
        // ...
    }
}
```



----------



## Continuous Integration

The project is continuously tested by [GitHub actions](https://github.com/ICanBoogie/bind-routing/actions).

[![Tests](https://github.com/ICanBoogie/bind-routing/workflows/test/badge.svg?branch=master)](https://github.com/ICanBoogie/bind-routing/actions?query=workflow%3Atest)
[![Static Analysis](https://github.com/ICanBoogie/bind-routing/workflows/static-analysis/badge.svg?branch=master)](https://github.com/ICanBoogie/bind-routing/actions?query=workflow%3Astatic-analysis)
[![Code Style](https://github.com/ICanBoogie/bind-routing/workflows/code-style/badge.svg?branch=master)](https://github.com/ICanBoogie/bind-routing/actions?query=workflow%3Acode-style)



## Code of Conduct

This project adheres to a [Contributor Code of Conduct](CODE_OF_CONDUCT.md). By participating in
this project and its community, you are expected to uphold this code.



## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.



## License

**icanboogie/bind-routing** is released under the [BSD-3-Clause](LICENSE).



[ICanBoogie]: https://icanboogie.org/
[icanboogie/icanboogie]:       https://github.com/ICanBoogie/ICanBoogie
[icanboogie/routing]:          https://github.com/ICanBoogie/Routing
[Application]:                 https://icanboogie.org/docs/4.0/the-application-class
