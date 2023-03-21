<?php

namespace ICanBoogie\Binding\Routing;

use Attribute;

/**
 * Used by {@link AttributeCompilerPass} to tag services with `action_responder`.
 */
#[Attribute(Attribute::TARGET_CLASS)]
final class ActionResponder
{
}
