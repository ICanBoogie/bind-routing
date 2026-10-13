# CHANGELOG

## v7.0

### New Requirements

- PHP 8.4+
- icanboogie/inflector 4.0+

### New features

- Adapted to the new routing config. `ConfigBuilder` wraps `ICanBoogie\Routing\ConfigBuilder` and builds a
  `ICanBoogie\Routing\Config`: use `add_controller()`, `discover_controllers()` and `cache_strategy()`. Use
  `CacheStrategy::COMPILE` in production, so the config can be cached as a PHP file, and `CacheStrategy::MEMOIZE` in
  development.
- The services `ICanBoogie\Routing\Config` and `ICanBoogie\Routing\RouteProvider` (`Config::$routes`) are provided.
- `ControllerCompilerPass` registers the controllers found through `ICanBoogie\Routing\Attribute\Route` as shared
  services. A controller added without attributes must be tagged with `routing.controller`.
- The `ActionResponderProvider` service is a `Chain` of `FromConfig` and the legacy provider, which responds for
  controllers tagged with `action_responder`.
- `routing:routes` and `routing:actions` list the controllers of the config.

### Backward Incompatible Changes

- `ConfigBuilder` no longer extends `RouteCollector`: `route()`, `get()`, `resource()`, `use_attributes()` etc. are
  gone. Routes are defined by controllers.
- The configuration is a `Config` instead of a `RouteProvider`; the `routes` fragment builder is registered for
  `ICanBoogie\Routing\Config`.
- Removed the attributes `ICanBoogie\Binding\Routing\Attribute\*`, use `ICanBoogie\Routing\Attribute\*`. The class
  level `#[Route('/prefix')]` becomes `#[Prefix(route: '/prefix')]`.
- Removed `ActionResolver` and `ActionResponderCompilerPass`. The action is now inferred by
  `ICanBoogie\Routing\ActionResolver`: the method name is used as is.
- Controllers using the attributes are stateless (not `ControllerAbstract`), they no longer get tagged with
  `action_responder` and `action_alias` automatically. Legacy controllers must be tagged by hand.

### Deprecated Features

None

### Other Changes

- Sort Actions and Routes in console


## v6.0

### New Requirements

PHP 8.1+

### New features

- Added the console command `routes:routes` (with alias `routes`), and `routing:actions`.

#### UrlTrait

`UrlTrait` can be used with prototyped objects to add a `url()` method and a `$url` property. The binding uses the `UrlMethod` service to generate the urls.

```php
<?php

namespace ICanBoogie;

use ICanBoogie\Binding\Routing\Prototype\UrlTrait;

class Article extends Prototyped
{
    use UrlTrait;

    // …
}

$article = new Article;

echo $article->url;
```

The prototype bindings can be inferred from the `UrlGetter` attribute (defined by `UrlTrait`) if `olvlvl/composer-attribute-collector` is available.

```php
<?php

// config/prototype.php

use ICanBoogie\Binding\Prototype\ConfigBuilder;
use ICanBoogie\Binding\Routing\Prototype\UrlMethod;

return fn(ConfigBuilder $config) => UrlMethod::bind($config);
```

### Backward Incompatible Changes

- Because `ControllerAbstract` no longer extends `Prototyped` and services are now expected to be provided through the constructor, `ControllerBindings` and `ForwardUndefinedPropertiesToApplication` have been removed.
- Removed `ApplicationBindings`. Removed `Application::url_for()` and `Application::get_routes()` prototype methods. Request the services `UrlGenerator` and `RouteProvider` instead.

### Deprecated Features

None

### Other Changes

None

<!--

### New Requirements

None

### New features

None

### Backward Incompatible Changes

None

### Deprecated Features

None

### Other Changes

None

-->
