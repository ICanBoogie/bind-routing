<?php

namespace Test\ICanBoogie\Binding\Routing\Acme;

use ICanBoogie\HTTP\Responder;
use ICanBoogie\Routing\Middleware;

/**
 * Wraps the responders in a {@see ProbeResponder}, which tells the middleware was collected.
 */
final class ProbeMiddleware implements Middleware
{
    #[\Override]
    public function responder(Responder $next): Responder
    {
        return new ProbeResponder($next);
    }
}
