<?php

/*
 * Copyright (c) 2023 Sura
 *
 *  For the full copyright and license information, please view the LICENSE
 *   file that was distributed with this source code.
 *
 */

namespace Sura\tests\Support;

use Sura\Support\Registry;
use PHPUnit\Framework\TestCase;

/**
 *
 */
class RegistryTest extends TestCase
{
    /**
     * @return void
     */
    final public function testSet(): void
    {
        $instance = Registry::set('ttt', 'qwerty');
        self::assertEquals('qwerty', $instance);
        Registry::set('ttt', 'word');
        Registry::set('1', 123);
        Registry::set('2', ['fff' => 12]);
        self::assertTrue(true);
    }

    /**
     * @return void
     */
    final public function testGet(): void
    {
        $instance = Registry::get('ttt');
        self::assertEquals('word', $instance);
        $instance = Registry::get('fail');
        self::assertEquals(null, $instance);
    }

    /**
     * @return void
     */
    final public function testExists(): void
    {
        $instance = Registry::get('ttt');
        self::assertEquals('word', $instance);
        $instance = Registry::get('fail');
        self::assertEquals(null, $instance);
    }
}
