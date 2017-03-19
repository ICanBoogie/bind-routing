<?php

namespace ICanBoogie\Binding\Routing\ControllerTest;

use ICanBoogie\Binding\Routing\ControllerBindings;
use ICanBoogie\Binding\Routing\ForwardUndefinedPropertiesToApplication;
use ICanBoogie\Routing\Controller;

abstract class BoundController extends Controller
{
	use ControllerBindings, ForwardUndefinedPropertiesToApplication;
}
