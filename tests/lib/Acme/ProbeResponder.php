<?php

namespace Test\ICanBoogie\Binding\Routing\Acme;

use ICanBoogie\HTTP\Request;
use ICanBoogie\HTTP\Responder;
use ICanBoogie\HTTP\Response;

final readonly class ProbeResponder implements Responder
{
    public function __construct(
        public Responder $next,
    ) {
    }

    #[\Override]
    public function respond(Request $request): Response
    {
        return $this->next->respond($request);
    }
}
