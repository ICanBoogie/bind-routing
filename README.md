# bind-routing

[![Packagist](https://img.shields.io/packagist/v/icanboogie/bind-routing.svg)](https://packagist.org/packages/icanboogie/bind-routing)
[![Code Quality](https://img.shields.io/scrutinizer/g/ICanBoogie/bind-routing.svg)](https://scrutinizer-ci.com/g/ICanBoogie/bind-routing)
[![Code Coverage](https://img.shields.io/coveralls/ICanBoogie/bind-routing.svg)](https://coveralls.io/r/ICanBoogie/bind-routing)
[![Downloads](https://img.shields.io/packagist/dt/icanboogie/bind-routing.svg)](https://packagist.org/packages/icanboogie/bind-routing)

The **icanboogie/bind-routing** package binds [ICanBoogie/Routing][] to [ICanBoogie][]. It provides infrastructure to configure routes and responders, a trait to get URLs from objects, and commands to list routes and actions.



#### Installation

```bash
composer require icanboogie/bind-routing
```



## Defining routes using attributes

The easiest way to define routes is to use routing attributes such as [Route][] or [Get][] to tag your controller and actions. Using any of these tags triggers the registration of the controller as a service (if it is not already registered), and the tagging with `action_responder` and `action_alias`.

The following example demonstrates how the [Route][] attribute can be used at the class level to specify a prefix for all the actions of a controller. The [Get][] and [Post][] attributes are used to tag actions. If left undefined, the action is inferred from the controller class and the method name.

```php
<?php

namespace App\Presentation\HTTP

use ICanBoogie\Accessor\AccessorTrait;use ICanBoogie\Binding\Routing\Attribute\Get;use ICanBoogie\Binding\Routing\Attribute\Route;use ICanBoogie\Routing\ControllerAbstract;

#[Route('/skills')]
final SkillController extends ControllerAbstract
{
    use AccessorTrait;

    // This will create a 'GET /skills' route with 'skills:list' action
    #[Get]
    private function list(): void
    {
        // …
    }

    // This will create a 'GET /skills/:slug' route with 'skills:show' action
    #[Get('/:slug')]
    private function show(string $slug): void
    {
        // …
    }

    // This will create a 'POST /skills' route with 'skills:create' action
    #[Post]
    private function create(): void
    {
        // …
    }
}
```

Using the `from_attributes()` method, the config builder can collect these attributes to configure itself.

```php
<?php
// app/all/config/routes.php

namespace App;

use ICanBoogie\Binding\Routing\ConfigBuilder;

return fn(ConfigBuilder $config) => $config->from_attributes();
```



## Defining routes using configuration fragments

Alternatively, you can configure routes manually using  `routes` configuration fragments, but you will have to register the service and tag it with `action_responder` and `action_alias`.

The following example demonstrates how to define routes, resource routes. The pattern of the `articles:show` route is overridden to use _year_, _month_ and _slug_.

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



## Getting route configuration

The following code demonstrates how to obtain a route provider from the _routes_ configuration:

```php
<?php

namespace ICanBoogie;

/** @var Application $app */

$routes = $app->config_for_class(Routing\RouteProvider::class);
```



----------



## Continuous Integration

The project is continuously tested by [GitHub actions](https://github.com/ICanBoogie/bind-routing/actions).

[![Tests](https://github.com/ICanBoogie/bind-routing/workflows/test/badge.svg)](https://github.com/ICanBoogie/bind-routing/actions?query=workflow%3Atest)
[![Static Analysis](https://github.com/ICanBoogie/bind-routing/workflows/static-analysis/badge.svg)](https://github.com/ICanBoogie/bind-routing/actions?query=workflow%3Astatic-analysis)
[![Code Style](https://github.com/ICanBoogie/bind-routing/workflows/code-style/badge.svg)](https://github.com/ICanBoogie/bind-routing/actions?query=workflow%3Acode-style)



## Code of Conduct

This project adheres to a [Contributor Code of Conduct](CODE_OF_CONDUCT.md). By participating in
this project and its community, you are expected to uphold this code.



## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.



## License

**icanboogie/bind-routing** is released under the [BSD-3-Clause](LICENSE).



[ICanBoogie]: https://icanboogie.org/
[ICanBoogie/Routing]: https://github.com/ICanBoogie/Routing
[Route]: lib/Attribute/Route.php
[Get]: lib/Attribute/Get.php
[ActionResponder]: lib/Attribute/ActionResponder.php
