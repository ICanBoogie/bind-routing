<?php

namespace ICanBoogie\Binding\Routing\Attribute;

use Attribute;
use ICanBoogie\HTTP\RequestMethod;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
final class Delete extends Route
{
    public function __construct(
        string $pattern,
        string|null $action = null,
        string|null $id = null,
    ) {
        parent::__construct($pattern, $action, RequestMethod::METHOD_DELETE, $id);
    }
}
