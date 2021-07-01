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

#
# Get routes configuration
#

$config = $app->configs['routes'];

#
# Get the route collection and add a new route
#

use ICanBoogie\HTTP\Request;
use ICanBoogie\Routing\RouteDefinition;

$app->routes->get('/hello', function(Request $request) {

	$who = $request['name'] ?: 'world';

	return "Hello $who!";

}, [ RouteDefinition::ID => 'hello' ]);

#
# Obtain de URL of an article
#

echo $app->url_for('articles:show', $app->models['articles']->one);
```





## Defining routes using configuration fragments

The most efficient way to define routes is through `routes` configuration fragments, because it
doesn't require application logic (additional code) and the synthesized configuration may be cached.

The following example demonstrates how to define routes, resource routes. The pattern of the
`articles:show` route is overridden to use _year_, _month_ and _slug_.

```php
<?php

// config/routes.php

namespace App;

use ICanBoogie\Routing\RouteDefinition;
use ICanBoogie\Routing\RouteMaker as Make;

return [

	'home' => [

		RouteDefinition::PATTERN => '/',
		RouteDefinition::CONTROLLER => PagesController::class,
		RouteDefinition::ACTION => Make::ACTION_INDEX

	]

] + array_replace_recursive(Make::resource('articles', ArticlesController::class), [

	'articles:show' => [

		RouteDefinition::PATTERN => '/articles/:year-:month-:slug.html'

	]

]);
```

The following code demonstrates how the synthesized `routes` configuration can be obtained:

```php
<?php

$routes_config = $app->configs['routes'];
```

> **Note:** To make it easy for you to find where routes are defined, the pathname to the
configuration fragment is set as `__ORIGIN__` in the route definition.





### Before the configuration is synthesized

The `routing.synthesize_routes:before` event of class [BeforeSynthesizeRoutesEvent][] is fired
before the configuration is synthesized. Event hooks may use this event to alter the configuration
fragments before they are synthesized.

The following example demonstrates how the `routing.synthesize_routes:before` event can be used to
alter the patterns of the route definitions before they synthesized:

```php
<?php

use ICanBoogie\Binding\Routing\BeforeSynthesizeRoutesEvent;
use ICanBoogie\Routing\RouteDefinition;

$app->events->attach('routing.synthesize_routes:before', function(BeforeSynthesizeRoutesEvent $event) {

	foreach ($event->fragments as &$fragment)
	{
		foreach ($fragment as &$definition)
		{
			$definition[RouteDefinition::PATTERN] = '/en' . $definition[RouteDefinition::PATTERN];
		}
	}

});
```





### The configuration is synthesized

The `routing.synthesize_routes` event of class [SynthesizeRoutesEvent][] is fired when the
configuration is synthesized. Event hooks may use this event to alter the synthesized configuration
before it is returned by the synthesizer.





----------





## Installation

```bash
composer require icanboogie/bind-routing
```





## Documentation

The package is documented as part of the [ICanBoogie][] framework [documentation][]. You can
generate the documentation for the package and its dependencies with the `make doc` command. The
documentation is generated in the `build/docs` directory. [ApiGen](http://apigen.org/) is required.
The directory can later be cleaned with the `make clean` command.





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
[documentation]:               https://icanboogie.org/api/bind-routing/4.0/
[BeforeSynthesizeRoutesEvent]: https://icanboogie.org/api/bind-routing/4.0/class-ICanBoogie.Binding.Routing.BeforeSynthesizeRoutesEvent.html
[SynthesizeRoutesEvent]:       https://icanboogie.org/api/bind-routing/4.0/class-ICanBoogie.Binding.Routing.SynthesizeRoutesEvent.html
