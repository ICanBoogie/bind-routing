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

use ICanBoogie\Binding\Prototype\ConfigBuilder;
use ICanBoogie\Binding\Routing\Prototype\UrlMethod;
use ICanBoogie\Routing\RouteMaker;
use PHPUnit\Framework\TestCase;
use Test\ICanBoogie\Binding\Routing\Acme\Article;
use Test\ICanBoogie\Binding\Routing\Acme\DanceSession;

use function ICanBoogie\Service\ref;

final class UrlMethodTest extends TestCase
{
    public function test_bind(): void
    {
        $config = new ConfigBuilder();

        UrlMethod::bind($config);

        $actual = $config->build()->bindings;
        $expected = [
            Article::class => [
                UrlMethod::METHOD => ref(UrlMethod::class)
            ],
            DanceSession::class => [
                UrlMethod::METHOD => ref(UrlMethod::class)
            ],
        ];

        $this->assertEquals($expected, $actual);
    }

    public function test_url(): void
    {
        $article = new Article(2022, 11, "hello-world");

        $this->assertEquals("/articles/2022-11-hello-world", $article->url);
        $this->assertEquals("/articles?order=-date", $article->url(RouteMaker::ACTION_LIST, [ 'order' => '-date' ]));

        $dance_session = new DanceSession('inspiring-plum');

        $this->assertEquals('/dance-sessions/inspiring-plum.html', $dance_session->url);
    }
}
