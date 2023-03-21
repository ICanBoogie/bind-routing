<?php

namespace ICanBoogie\Binding\Routing;

use Attribute;

/**
 * Used by {@link AttributeCompilerPass} to tag services with `action_alias`.
 */
#[Attribute(Attribute::TARGET_METHOD|Attribute::IS_REPEATABLE)]
final class Action
{
    public function __construct(
        public readonly ?string $action = null,
    ) {
    }
}
