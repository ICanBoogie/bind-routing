<?php

namespace ICanBoogie\Binding\Routing\Console;

use ICanBoogie\HTTP\RequestMethod;
use ICanBoogie\HTTP\Responder;
use ICanBoogie\Routing\RouteProvider;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use function array_map;
use function implode;
use function is_array;
use function is_null;
use function is_string;
use function strtoupper;

/**
 * Lists routes defined with Autoconfig.
 */
#[AsCommand('routing:routes|routes', "List routes")]
final class ListRoutesCommand extends Command
{
    private const OPT_MATCHES_URI = 'matches-uri';
    private const OPT_MATCHES_METHOD = 'matches-method';

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

    protected function configure(): void
    {
        $this->addOption(
            self::OPT_MATCHES_URI,
            'u',
            InputOption::VALUE_OPTIONAL,
            "Filter routes matching the URI",
        );

        $this->addOption(
            self::OPT_MATCHES_METHOD,
            'm',
            InputOption::VALUE_OPTIONAL,
            "Filter routes matching the HTTP method",
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $matches_uri = $input->getOption(self::OPT_MATCHES_URI);
        $matches_method = $input->getOption(self::OPT_MATCHES_METHOD);

        assert(is_string($matches_uri) or is_null($matches_uri));
        assert(is_string($matches_method) or is_null($matches_method));

        $matches_method = $matches_method ? RequestMethod::from(strtoupper($matches_method)) : null;

        $rows = [];

        foreach ($this->config as $route) {
            if ($matches_uri && !$route->pattern->matches($matches_uri)) {
                continue;
            }

            if ($matches_method && !$route->method_matches($matches_method)) {
                continue;
            }

            $rows[] = [
                self::render_methods($route->methods),
                $route->pattern,
                $route->action,
                $route->id,
                $this->aliases[$route->action] ?? "",
            ];
        }

        if (!$rows && ($matches_uri || $matches_method)) {
            $output->writeln("<error>The query doesn't match any route</error>");

            return Command::FAILURE;
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
