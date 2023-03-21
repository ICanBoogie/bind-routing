<?php

namespace ICanBoogie\Binding\Routing\Console;

use ICanBoogie\HTTP\RequestMethod;
use ICanBoogie\HTTP\Responder;
use ICanBoogie\Routing\RouteProvider;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use function array_map;
use function implode;
use function is_array;

/**
 * Lists routes defined with Autoconfig.
 */
#[AsCommand('routing:routes|routes', "List routes")]
final class ListRoutesCommand extends Command
{
    /**
     * @param array<string, class-string<Responder>> $aliases
     *     Where _key_ is an action and _value_ a responder class.
     */
    public function __construct(
        private readonly RouteProvider $config,
        private readonly array $aliases,
        private readonly string $style,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $rows = [];

        foreach ($this->config as $route) {
            $rows[] = [
                self::render_methods($route->methods),
                $route->pattern,
                $route->action,
                $route->id,
                $this->aliases[$route->action] ?? "",
            ];
        }

        $table = new Table($output);
        $table->setHeaders([ 'Methods', 'Pattern', 'Action', 'Id', 'Responder' ]);
        $table->setRows($rows);
        $table->setStyle($this->style);
        $table->render();

        return Command::SUCCESS;
    }

    /**
     * @param RequestMethod|RequestMethod[] $methods
     */
    private static function render_methods(RequestMethod|array $methods): string
    {
        if (!is_array($methods)) {
            $methods = [ $methods ];
        }

        $methods = array_map(fn(RequestMethod $method) => $method->value, $methods);

        return implode(' ', $methods);
    }
}
