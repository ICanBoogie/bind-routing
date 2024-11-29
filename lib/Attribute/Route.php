<?php

namespace ICanBoogie\Binding\Routing\Attribute;

use Attribute;
use ICanBoogie\HTTP\RequestMethod;

#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
class Route
{
    /**
     * @param string $pattern
     *     The pattern of the route.
     *     It is alright to have an _empty_ pattern as long as a {@see Route} is defined on the controller class
     *     to define the base pattern.
     * @param string|null $action
     *     Identifier of a qualified action; for example, 'articles:show'.
     *     If it is not defined, the action might be resolved from the controller and the method.
     * @param RequestMethod|RequestMethod[] $methods
     *     Request method(s) accepted by the route.
     * @param string|null $id
     */
    public function __construct(
        public readonly string $pattern,
        public readonly ?string $action = null,
        public readonly RequestMethod|array $methods = RequestMethod::METHOD_ANY,
        public readonly ?string $id = null,
    ) {
    }
}
