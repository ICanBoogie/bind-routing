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

use ICanBoogie\PropertyNotDefined;
use PHPUnit\Framework\TestCase;
use Test\ICanBoogie\Binding\Routing\ControllerTest\BoundController as Controller;
use Throwable;

use function ICanBoogie\app;

final class ControllerTest extends TestCase
{
    public function test_get_application_property()
    {
        $controller = $this
            ->getMockBuilder(Controller::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        /* @var $controller Controller */

        $this->assertSame(app()->routes, $controller->routes);
    }

    public function test_last_chance_get_application_get_undefined()
    {
        $property = 'property' . uniqid();

        $controller = $this
            ->getMockBuilder(Controller::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        /* @var $controller Controller */

        try {
            $controller->$property;

            $this->fail('Expected PropertyNotDefined');
        } catch (Throwable $e) {
            $this->assertInstanceOf(PropertyNotDefined::class, $e);

            $message = $e->getMessage();

            $this->assertStringContainsString($property, $message);
            $this->assertStringContainsString(get_class($controller), $message);
        }
    }
}
