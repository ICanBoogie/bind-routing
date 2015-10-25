<?php

namespace ICanBoogie\Binding\Routing;

use ICanBoogie\Routing\Pattern;

class WarmPatterns extends Pattern
{
	static public function warm_from_config(array $config)
	{
		$parsed_patterns = [];

		foreach ($config as $id => $definition)
		{
			if (empty($definition['__PARSED_PATTERN__']))
			{
				continue;
			}

			$parsed_patterns[$id] = $definition['__PARSED_PATTERN__'];
		}

		if (!$parsed_patterns)
		{
			return;
		}

		self::warm($parsed_patterns);
	}

	static public function warm(array $parsed_patterns)
	{
		self::$parsed += $parsed_patterns;
	}
}
