<?php

namespace ICanBoogie\Binding\Routing\Console;

use ICanBoogie\HTTP\Responder;
use ICanBoogie\Routing\Config;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use function ICanBoogie\shorten;

/**
 * Lists actions and the responders that respond to them.
 */
#[AsCommand('routing:actions', "List actions")]
final class ListActionsCommand extends Command
{
    /**
     * @param array<string, class-string<Responder>> $aliases
     *     Where _key_ is an action and _value_ a responder class, for controllers tagged with `action_responder`.
     */
    public function __construct(
        private readonly Config $config,
        private readonly array $aliases,
        private readonly string $style,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $rows = [];

        foreach ($this->config->routes as $route) {
            $rows[] = [
                $route->action,
                shorten(
                    HandlerResolver::resolve(
                        $route->action,
                        $this->config,
                        $this->aliases
                    ),
                    length: 36,
                    position: 0
                ),
            ];
        }

        usort($rows, fn($a, $b) => $a[0] <=> $b[0]);

        $table = new Table($output);
        $table->setHeaders([ 'Action', 'Responder' ]);
        $table->setRows($rows);
        $table->setStyle($this->style);
        $table->render();

        return Command::SUCCESS;
    }
}
