<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class ImplodeTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::implode()
     */
    public function testImplode()
    {
        $this->assertSame('', Collection::instance()->implode());
        $this->assertSame('', Collection::instance()->implode(', '));
        $this->assertSame('', Collection::instance()->implode(', ', ' and '));

        $this->assertSame('a', Collection::instance(['a'])->implode());
        $this->assertSame('a', Collection::instance(['a'])->implode(', '));
        $this->assertSame('a', Collection::instance(['a'])->implode(', ', ' and '));

        $this->assertSame('ab', Collection::instance(['a', 'b'])->implode());
        $this->assertSame('a, b', Collection::instance(['a', 'b'])->implode(', '));
        $this->assertSame('a and b', Collection::instance(['a', 'b'])->implode(', ', ' and '));

        $this->assertSame('abc', Collection::instance(['a', 'b', 'c'])->implode());
        $this->assertSame('a, b, c', Collection::instance(['a', 'b', 'c'])->implode(', '));
        $this->assertSame('a, b and c', Collection::instance(['a', 'b', 'c'])->implode(', ', ' and '));

        $this->assertSame('abcd', Collection::instance(['a', 'b', 'c', 'd'])->implode());
        $this->assertSame('a, b, c, d', Collection::instance(['a', 'b', 'c', 'd'])->implode(', '));
        $this->assertSame('a, b, c and d', Collection::instance(['a', 'b', 'c', 'd'])->implode(', ', ' and '));
    }
}
