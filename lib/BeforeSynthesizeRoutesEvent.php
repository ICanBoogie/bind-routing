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
 * Event class for the `routing.synthesize_routes:before` event.
 *
 * Third parties may use this event to alter the configuration fragments before they are
 * synthesized.
 */
class BeforeSynthesizeRoutesEvent extends Event
{
	/**
	 * Reference to the configuration fragments.
	 *
	 * @var array
	 */
	public $fragments;

	/**
	 * The event is constructed with the type `routing.synthesize_routes:before`.
	 *
	 * @param array $fragments Reference to the fragments to alter.
	 */
	public function __construct(&$fragments)
	{
		$this->fragments = &$fragments;

		parent::__construct(null, 'routing.synthesize_routes:before');
	}
}
