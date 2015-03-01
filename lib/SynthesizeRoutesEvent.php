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

use ICanBoogie\Event;

/**
 * Event class for the `routing.synthesize_routes` event.
 *
 * Third parties may use this event to alter the synthesized configuration before it is
 * returned by the synthesizer.
 */
class SynthesizeRoutesEvent extends Event
{
	/**
	 * Reference to route definitions.
	 *
	 * @var array
	 */
	public $routes;

	/**
	 * The event is constructed with the type `collect`.
	 *
	 * @param array $routes The route collection.
	 */
	public function __construct(array &$routes)
	{
		$this->routes = &$routes;

		parent::__construct(null, 'routing.synthesize_routes');
	}
}
