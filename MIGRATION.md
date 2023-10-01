# Migration

## v5.x to v6.0

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
