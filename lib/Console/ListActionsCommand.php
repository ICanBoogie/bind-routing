<?php

namespace ICanBoogie\Binding\Routing\Console;

use ICanBoogie\HTTP\Responder;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Lists routes defined with Autoconfig.
 */
#[AsCommand('routing:actions', "List routes")]
final class ListActionsCommand extends Command
{
    /**
     * @param array<string, class-string<Responder>> $aliases
     *     Where _key_ is an action and _value_ a responder class.
     */
    public function __construct(
        private readonly array $aliases,
        private readonly string $style,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $rows = [];

        foreach ($this->aliases as $action => $responder) {
            $rows[] = [
                $action,
                $responder,
            ];
        }

        $table = new Table($output);
        $table->setHeaders([ 'Action', 'Responder' ]);
        $table->setRows($rows);
        $table->setStyle($this->style);
        $table->render();

        return Command::SUCCESS;
    }
}
