<?php

namespace Test\ICanBoogie\Binding\Routing\Console;

use ICanBoogie\Binding\Routing\Console\ListRoutesCommand;
use ICanBoogie\Console\Test\CommandTestCase;

final class ListRoutesCommandTest extends CommandTestCase
{
    public static function provideExecute(): array
    {
        return [

            [
                'routing:routes',
                ListRoutesCommand::class,
                [],
                [
                    'ANY',
                    '/api/ping',
                    'api:ping',
                    ' ',
                    'ICanBoogie\Routing\PingController',
                ],
            ],

        ];
    }
}
