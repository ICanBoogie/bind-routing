<?php

namespace ICanBoogie\Binding\Routing\Attribute;

use Attribute;
use ICanBoogie\HTTP\RequestMethod;

#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
class Route
{
    /**
     * @param string $pattern
     *     Pattern of the route.
     *     It's alright to have an _empty_ pattern as long as a {@link Route} is defined on the controller class
     *     to define the base pattern.
     * @param string|null $action
     *     Identifier of a qualified action. e.g. 'articles:show'.
     *     If it is not defined, the action might be resolved from the controller and the method.
     * @param RequestMethod|RequestMethod[] $methods
     *     Request method(s) accepted by the respond.
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
