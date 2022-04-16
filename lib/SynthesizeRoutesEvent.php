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
use ICanBoogie\Routing\Route;

/**
 * Event class for the `routing.synthesize_routes` event.
 *
 * Third parties may use this event to alter the synthesized configuration before it is
 * returned by the synthesizer.
 */
final class SynthesizeRoutesEvent extends Event
{
	public const TYPE = 'routing.synthesize_routes';

	/**
	 * Reference to route definitions.
	 *
	 * @var Route[]
	 */
	public array $routes;

	/**
	 * The event is constructed with the type `collect`.
	 *
	 * @param Route[] $routes The route collection.
	 */
	public function __construct(array &$routes)
	{
		$this->routes = &$routes;

		parent::__construct(null, self::TYPE);
	}
}
