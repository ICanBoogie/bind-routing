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
 * Listener may use this event to alter the configuration fragments before they are synthesized.
 */
class BeforeSynthesizeRoutesEvent extends Event
{
	/**
	 * Reference to the configuration fragments.
	 */
	public array $fragments;

	/**
	 * @param array $fragments Reference to the fragments to alter.
	 */
	public function __construct(array &$fragments)
	{
		$this->fragments = &$fragments;

		parent::__construct(null);
	}
}
