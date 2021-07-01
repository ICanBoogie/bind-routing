<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Binding\Routing;

use ICanBoogie\Application;
use ICanBoogie\PropertyNotDefined;
use ICanBoogie\Routing\RouteCollection;

/**
 * Forwards undefined properties to the application.
 *
 * **Note:** This trait is to be used by classes extending
 * {@link \ICanBoogie\Accessor\AccessorTrait}.
 *
 * @property Application $app
 * @property-read RouteCollection $routes
 */
trait ForwardUndefinedPropertiesToApplication
{
	/**
	 * Tries to get the undefined property from the application.
	 */
	protected function last_chance_get(string $property, bool &$success): mixed
	{
		try
		{
			$value = $this->app->$property;
			$success = true;

			return $value;
		}
		catch (PropertyNotDefined $e)
		{
			// We don't mind that the property is not defined by the app
		}

		return parent::last_chance_get($property, $success);
	}
}
