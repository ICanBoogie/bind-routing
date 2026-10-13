<?php

use ICanBoogie\Binding\Routing\ActionAliasCompilerPass;
use ICanBoogie\Binding\Routing\ControllerCompilerPass;
use ICanBoogie\Binding\SymfonyDependencyInjection\ConfigBuilder;

return fn(ConfigBuilder $config) => $config
	->add_compiler_pass(ControllerCompilerPass::class)
	->add_compiler_pass(ActionAliasCompilerPass::class);
