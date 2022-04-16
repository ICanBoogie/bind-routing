<?php

namespace ICanBoogie\Routing;

return [

	new Route('/', 'home'),
	...RouteMaker::resource('articles'),

];
