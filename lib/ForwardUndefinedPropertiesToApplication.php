<?php

namespace ICanBoogie\Binding\Routing;

use ICanBoogie\Core;
use ICanBoogie\PropertyNotDefined;
use ICanBoogie\Routing\RouteCollection;

/**
 * Forwards undefined properties to the application.
 *
 * **Note:** This trait is to be used by classes extending
 * {@link \ICanBoogie\Accessor\AccessorTrait}.
 *
 * @property Core $app
 * @property-read RouteCollection $routes
 */
trait ForwardUndefinedPropertiesToApplication
{
	/**
	 * Tries to get the undefined property from the application.
	 *
	 * @param string $property
	 * @param bool $success
	 *
	 * @return mixed
	 */
	protected function last_chance_get($property, &$success)
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
