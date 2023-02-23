<?php

namespace ICanBoogie\Binding\Routing\Console;

use ICanBoogie\HTTP\RequestMethod;
use ICanBoogie\Routing\RouteProvider;
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
final class ListRoutesCommand extends Command
{
    protected static $defaultDescription = "List routes";

    public function __construct(
        private readonly RouteProvider $config,
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
                $route->id
            ];
        }

        $table = new Table($output);
        $table->setHeaders([ 'Methods', 'Pattern', 'Action', 'Id' ]);
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
