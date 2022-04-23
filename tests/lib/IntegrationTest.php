<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Test\ICanBoogie\Binding\Routing;

use ICanBoogie\HTTP\Request;
use ICanBoogie\HTTP\RequestMethod;
use PHPUnit\Framework\TestCase;

use function ICanBoogie\app;

final class IntegrationTest extends TestCase
{
    public function test_route(): void
    {
        $this->markTestSkipped("The response is not returned, it is executed.");

        $request = Request::from([

            Request::OPTION_METHOD => RequestMethod::METHOD_GET,
            Request::OPTION_URI => '/articles/123',

        ]);

        $response = (app())($request);
    }
}
