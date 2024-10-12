<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class SumTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::sum()
     */
    public function testSum()
    {
        $this->assertSame(6, Collection::instance([1, 2, 3])->sum());
        $this->assertSame(5050, Collection::range(1, 100)->sum());
        $this->assertSame(3, Collection::instance([1, 2, 'a'])->sum());
    }
}
