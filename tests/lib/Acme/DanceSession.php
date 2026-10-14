<?php

namespace Test\ICanBoogie\Binding\Routing\Acme;

use ICanBoogie\Binding\Routing\Prototype\UrlTrait;
use ICanBoogie\Prototyped;
use olvlvl\ComposerAttributeCollector\InheritsAttributes;

#[InheritsAttributes]
final class DanceSession extends Prototyped
{
    use UrlTrait;

    public function __construct(
        public readonly string $slug
    ) {
    }
}
