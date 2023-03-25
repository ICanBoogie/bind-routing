<?php

namespace ICanBoogie\Binding\Routing\Attribute;

use Attribute;

/**
 * Used by {@link ActionResponderCompilerPass} to tag services with `action_responder`.
 */
#[Attribute(Attribute::TARGET_CLASS)]
final class ActionResponder
{
}
