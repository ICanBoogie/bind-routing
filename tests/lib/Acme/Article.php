<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Test\ICanBoogie\Binding\Routing\Acme;

use ICanBoogie\Binding\Routing\Prototype\UrlTrait;
use ICanBoogie\Prototyped;
use olvlvl\ComposerAttributeCollector\InheritsAttributes;

#[InheritsAttributes]
final class Article extends Prototyped
{
    use UrlTrait;

    public function __construct(
        public int $year,
        public int $month,
        public string $slug
    ) {
    }
}
