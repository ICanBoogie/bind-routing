# bind-routing

[![Release](https://img.shields.io/packagist/v/icanboogie/bind-routing.svg)](https://packagist.org/packages/icanboogie/bind-routing)
[![Code Coverage](https://coveralls.io/repos/github/ICanBoogie/bind-routing/badge.svg?branch=7.0)](https://coveralls.io/r/ICanBoogie/bind-routing?branch=7.0)
[![Downloads](https://img.shields.io/packagist/dt/icanboogie/bind-routing.svg)](https://packagist.org/packages/icanboogie/bind-routing)

The **icanboogie/bind-routing** package binds [ICanBoogie/Routing][] to [ICanBoogie][]. It provides infrastructure to configure routes and responders, a trait to get URLs from objects, and commands to list routes and actions.



#### Installation

```shell
composer require icanboogie/bind-routing
```



## Defining routes using attributes

Routes are defined by controllers, with the attributes of [icanboogie/routing][] such as `Get` or `Post`. The class
attribute `Prefix` defines the prefixes shared by the methods. If left undefined, the action is inferred from the
controller class and the method name (`SkillController::show` is `skills:show`).

```php
<?php

namespace App\Presentation\HTTP;

use ICanBoogie\HTTP\Response;
use ICanBoogie\Routing\Attribute\Get;
use ICanBoogie\Routing\Attribute\Post;
use ICanBoogie\Routing\Attribute\Prefix;

#[Prefix(route: '/skills')]
final class SkillController
{
    // This will create a 'GET /skills' route with 'skills:list' action
    #[Get]
    public function list(): Response
    {
        // …
    }

    // This will create a 'GET /skills/:slug' route with 'skills:show' action
    #[Get('/:slug')]
    public function show(string $slug): Response
    {
        // …
    }

    // This will create a 'POST /skills' route with 'skills:create' action
    #[Post]
    public function create(): Response
    {
        // …
    }
}
```

Controllers are discovered with [olvlvl/composer-attribute-collector][], and registered as shared services:

```php
<?php
// app/all/config/routes.php

namespace App;

use ICanBoogie\Binding\Routing\ConfigBuilder;
use ICanBoogie\Routing\CacheStrategy;

return fn(ConfigBuilder $config) => $config
    ->discover_controllers()
    // Meant for production, use CacheStrategy::MEMOIZE in development.
    ->cache_strategy(CacheStrategy::COMPILE);
```

Use `add_controller()` to add a controller by hand, with an optional route builder instead of attributes. Such a
controller must be tagged with `routing.controller`, so it can be obtained from the container:

```php
<?php

use ICanBoogie\Binding\Routing\ConfigBuilder;
use ICanBoogie\Routing\RouteBuilder;

return fn(ConfigBuilder $config) => $config
    ->add_controller(ContactController::class, fn(RouteBuilder $r) => $r
        ->get('/contact.html', 'new')
        ->post('/contact.html', 'create'));
```

```yaml
services:
  App\Presentation\HTTP\ContactController:
    tags: [ routing.controller ]
```

In development, use `CacheStrategy::MEMOIZE`.



## Legacy controllers

Controllers extending `ControllerAbstract` still work, but they have to be registered and tagged with
`action_responder` and `action_alias`, their routes have to be provided separately:

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



## Getting route configuration

The following code demonstrates how to obtain a route provider from the _routes_ configuration:

```php
<?php

namespace ICanBoogie;

/** @var Application $app */

$config = $app->config_for_class(Routing\Config::class);
$routes = $config->routes;
```



----------



## Continuous Integration

The project is continuously tested by [GitHub actions](https://github.com/ICanBoogie/bind-routing/actions).

[![Tests](https://github.com/ICanBoogie/bind-routing/actions/workflows/test.yml/badge.svg?branch=7.0)](https://github.com/ICanBoogie/bind-routing/actions/workflows/test.yml)
[![Static Analysis](https://github.com/ICanBoogie/bind-routing/actions/workflows/static-analysis.yml/badge.svg?branch=7.0)](https://github.com/ICanBoogie/bind-routing/actions/workflows/static-analysis.yml)
[![Code Style](https://github.com/ICanBoogie/bind-routing/actions/workflows/code-style.yml/badge.svg?branch=7.0)](https://github.com/ICanBoogie/bind-routing/actions/workflows/code-style.yml)



## Code of Conduct

This project adheres to a [Contributor Code of Conduct](CODE_OF_CONDUCT.md). By participating in
this project and its community, you're expected to uphold this code.



## Contributing

See [CONTRIBUTING](CONTRIBUTING.md) for details.



[ICanBoogie]: https://icanboogie.org/
[ICanBoogie/Routing]: https://github.com/ICanBoogie/Routing
[ActionResponder]: lib/Attribute/ActionResponder.php
[icanboogie/routing]: https://github.com/ICanBoogie/Routing
[olvlvl/composer-attribute-collector]: https://github.com/olvlvl/composer-attribute-collector
