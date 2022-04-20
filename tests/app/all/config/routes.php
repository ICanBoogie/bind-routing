<?php

use ICanBoogie\Binding\Routing\ConfigBuilder;

return function (ConfigBuilder $config) {

	$config->route('/', 'home');
	$config->resource('articles');

};
