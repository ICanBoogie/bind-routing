# Migration

## v5.x to v6.0

### New Requirements

None

### New features

- `UrlTrait` and `UrlMethod` can be used to prototyped objects to add a `url()` method and a `$url` property.

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

### Backward Incompatible Changes

- Because `ControllerAbstract` no longer extends `Prototyped` and services are now expected to be provided through the constructor, `ControllerBindings` and `ForwardUndefinedPropertiesToApplication` have been removed.

### Deprecated Features

- Removed `Application::url_for()` prototype method. Request the service implementing `UrlGenerator` instead.

### Other Changes

- Compatible with PHP 8.2+
