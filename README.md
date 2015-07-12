# bind-routing

[![Release](https://img.shields.io/packagist/v/icanboogie/bind-routing.svg)](https://packagist.org/packages/icanboogie/bind-routing)
[![Build Status](https://img.shields.io/travis/ICanBoogie/bind-routing/master.svg)](http://travis-ci.org/ICanBoogie/bind-routing)
[![HHVM](https://img.shields.io/hhvm/icanboogie/bind-routing.svg)](http://hhvm.h4cc.de/package/icanboogie/bind-routing)
[![Code Quality](https://img.shields.io/scrutinizer/g/ICanBoogie/bind-routing/master.svg)](https://scrutinizer-ci.com/g/ICanBoogie/bind-routing)
[![Code Coverage](https://img.shields.io/coveralls/ICanBoogie/bind-routing/master.svg)](https://coveralls.io/r/ICanBoogie/bind-routing)
[![Packagist](https://img.shields.io/packagist/dt/icanboogie/bind-routing.svg)](https://packagist.org/packages/icanboogie/bind-routing)

The **icanboogie/bind-routing** package binds [icanboogie/routing][] to [ICanBoogie][], using its autoconfig feature. It adds the getter `routes` to the [Core][] instance and a synthesizer for the `routes` configuration fragments.

```php
<?php

namespace ICanBoogie;

$app = boot();

$routes_configuration = $app->configs['routes'];
echo get_class($app->routes); // ICanBoogie\RouteCollection
```





## Defining routes using configuration fragments

The most efficient way to define routes is through `routes` configuration fragments, because it doesn't require application logic (additional code) and the synthesized configuration can be cached.

The following example demonstrates how to define routes, resource routes. The pattern of the `articles:show` route is overridden to use _year_, _month_ and _slug_.

```php
<?php

// config/routes.php

namespace App;

use ICanBoogie\Routing\RoutesMaker as Make;

return [

	'home' => [

		'pattern' => '/',
		'controller' => PagesController::class . '#index'

	]
	
] + \ICanBoogie\array_merge_recursive(Make::resource('articles', ArticlesController::class), [

	'articles:show' => [
	
		'pattern' => '/articles/:year-:month-:slug.html'
	
	]

]);
```

The following code demonstrates how the synthesized `routes` configuration can be obtained:

```php
<?php

$routes_config = $app->configs['routes'];
```





### Before the configuration is synthesized

The `routing.synthesize_routes:before` event of class [BeforeSynthesizeRoutesEvent][] is fired before the configuration is synthesized. Event hooks may use this event to alter the configuration fragments before they are synthesized.

The following example demonstrates how the `routing.synthesize_routes:before` event can be used to alter the patterns of the route definitions before they synthesized:

```php
<?php

use ICanBoogie\Binding\Routing\BeforeSynthesizeRoutesEvent;

$app->events->attach('routing.synthesize_routes:before', function(BeforeSynthesizeRoutesEvent $event) {

	foreach ($event->fragments as &$fragment)
	{
		foreach ($fragment as &$definition)
		{
			$definition['pattern'] = '/en' . $definition['pattern'];
		}
	}

});
```





### The configuration is synthesized

The `routing.synthesize_routes` event of class [SynthesizeRoutesEvent][] is fired when the configuration is synthesized. Event hooks may use this event to alter the synthesized configuration before it is returned by the synthesizer.





----------





## Requirements

The package requires PHP 5.5 or later.





## Installation

The recommended way to install this package is through [Composer](http://getcomposer.org/):

```
$ composer require icanboogie/bind-routing
```

The package only specifies a minimum version while requiring [icanboogie/icanboogie][] and [icanboogie/routing], you might want to specify which version to use in your "composer.json" file.





### Cloning the repository

The package is [available on GitHub](https://github.com/ICanBoogie/bind-routing), its repository can be cloned with the following command line:

	$ git clone https://github.com/ICanBoogie/bind-routing.git





## Documentation

The package is documented as part of the [ICanBoogie][] framework
[documentation](http://icanboogie.org/docs/). You can generate the documentation for the package and its dependencies with the `make doc` command. The documentation is generated in the `build/docs` directory. [ApiGen](http://apigen.org/) is required. The directory can later be cleaned with the `make clean` command.





## Testing

The test suite is ran with the `make test` command. [PHPUnit](https://phpunit.de/) and [Composer](http://getcomposer.org/) need to be globally available to run the suite. The command installs dependencies as required. The `make test-coverage` command runs test suite and also creates an HTML coverage report in "build/coverage". The directory can later be cleaned with the `make clean` command.

The package is continuously tested by [Travis CI](http://about.travis-ci.org/).

[![Build Status](https://img.shields.io/travis/ICanBoogie/bind-routing/master.svg)](https://travis-ci.org/ICanBoogie/bind-routing)
[![Code Coverage](https://img.shields.io/coveralls/ICanBoogie/bind-routing/master.svg)](https://coveralls.io/r/ICanBoogie/bind-routing)





## License

**icanboogie/bind-routing** is licensed under the New BSD License - See the [LICENSE](LICENSE) file for details.





[icanboogie/icanboogie]: https://github.com/ICanBoogie/ICanBoogie
[icanboogie/routing]: https://github.com/ICanBoogie/Routing
[ICanBoogie]: https://github.com/ICanBoogie/ICanBoogie
[Core]: http://icanboogie.org/docs/class-ICanBoogie.Core.html
[BeforeSynthesizeRoutesEvent]: http://icanboogie.org/docs/class-ICanBoogie.Binding.Routing.BeforeSynthesizeRoutesEvent.html
[SynthesizeRoutesEvent]: http://icanboogie.org/docs/class-ICanBoogie.Binding.Routing.SynthesizeRoutesEvent.html
