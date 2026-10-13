<?php

namespace Test\ICanBoogie\Binding\Routing\Acme;

use ICanBoogie\HTTP\Response;
use ICanBoogie\Routing\Attribute\Get;

final class DanceSessionController
{
    #[Get('/dance-sessions/:slug.html', 'dance-sessions:show')]
    public function show(string $slug): Response
    {
        return new Response();
    }
}
