<?php

namespace Test\ICanBoogie\Binding\Routing\Console;

use ICanBoogie\Binding\Routing\Console\ListActionsCommand;
use ICanBoogie\Console\Test\CommandTestCase;

final class ListActionsCommandTest extends CommandTestCase
{
    public static function provideExecute(): array
    {
        return [

            [
                'routing:actions',
                ListActionsCommand::class,
                [],
                [
                    'api:ping',
                    'ICanBoogie\Routing\PingController',
                ],
            ],

        ];
    }
}
