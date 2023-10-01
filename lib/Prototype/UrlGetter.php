<?php

namespace ICanBoogie\Binding\Routing\Prototype;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
final class UrlGetter
{
    public function __construct()
    {
    }
}
