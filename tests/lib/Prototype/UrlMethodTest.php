<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Test\ICanBoogie\Binding\Routing\Prototype;

use ICanBoogie\Routing\RouteMaker;
use PHPUnit\Framework\TestCase;

final class UrlMethodTest extends TestCase
{
    public function test_url(): void
    {
        $article = new Article(2022, 11, "hello-world");

        $this->assertEquals("/articles/2022-11-hello-world", $article->url);
        $this->assertEquals("/articles?order=-date", $article->url(RouteMaker::ACTION_LIST, [ 'order' => '-date' ]));
    }
}
