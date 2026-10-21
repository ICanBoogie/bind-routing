<?php

namespace Test\ICanBoogie\Binding\Routing\Acme;

use ICanBoogie\HTTP\Responder;
use ICanBoogie\Routing\Middleware;

/**
 * Autoconfigured, and tagged by hand with a priority: its service is tagged twice, it must wrap the responders once.
 */
final class PriorityMiddleware implements Middleware
{
    #[\Override]
    public function responder(Responder $next): Responder
    {
        return new PriorityResponder($next);
    }
}
