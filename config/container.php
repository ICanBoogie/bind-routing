<?php

use ICanBoogie\Binding\Routing\ActionAliasCompilerPass;
use ICanBoogie\Binding\Routing\ActionResponderCompilerPass;
use ICanBoogie\Binding\SymfonyDependencyInjection\ConfigBuilder;

return fn(ConfigBuilder $config) => $config
	->add_compiler_pass(ActionResponderCompilerPass::class)
	->add_compiler_pass(ActionAliasCompilerPass::class);
