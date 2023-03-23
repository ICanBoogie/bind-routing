<?php

namespace ICanBoogie\Binding\Routing\Attribute;

use Attribute;
use ICanBoogie\HTTP\RequestMethod;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class Route
{
    /**
     * @param string $pattern
     *     Pattern of the route.
     * @param string|null $action
     *     Identifier of a qualified action. e.g. 'articles:show'.
     *     If it is not defined, the action might be resolved from the controller and the method.
     * @param RequestMethod|RequestMethod[] $methods
     *     Request method(s) accepted by the respond.
     * @param string|null $id
     */
    public function __construct(
        public readonly string $pattern,
        public readonly string|null $action = null,
        public readonly RequestMethod|array $methods = RequestMethod::METHOD_ANY,
        public readonly string|null $id = null,
    ) {
    }
}
