<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use ICanBoogie\Binding\Routing\ActionAliasCompilerPass;
use ICanBoogie\Binding\Routing\AttributeCompilerPass;
use ICanBoogie\Binding\SymfonyDependencyInjection\ConfigBuilder;

return fn(ConfigBuilder $config) => $config
	->add_compiler_pass(AttributeCompilerPass::class)
	->add_compiler_pass(ActionAliasCompilerPass::class);
