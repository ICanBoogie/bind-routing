<?php

namespace ICanBoogie\Binding\Routing\Attribute;

use Attribute;
use ICanBoogie\HTTP\RequestMethod;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
final class Trace extends Route
{
    public function __construct(
        string $pattern = '',
        ?string $action = null,
        ?string $id = null,
    ) {
        parent::__construct($pattern, $action, RequestMethod::METHOD_TRACE, $id);
    }
}
