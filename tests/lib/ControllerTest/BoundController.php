<?php

namespace Test\ICanBoogie\Binding\Routing\ControllerTest;

use ICanBoogie\Binding\Routing\ControllerBindings;
use ICanBoogie\Binding\Routing\ForwardUndefinedPropertiesToApplication;
use ICanBoogie\Routing\ControllerAbstract;

abstract class BoundController extends ControllerAbstract
{
    use ControllerBindings;
    use ForwardUndefinedPropertiesToApplication;
}
