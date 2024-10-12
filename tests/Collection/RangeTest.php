<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class RangeTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::range()
     */
    public function testRange()
    {
        $this->assertSame(range(1, 100), Collection::range(1, 100)->array());
        $this->assertSame(range(1, 100, 20), Collection::range(1, 100, 20)->array());
        $this->assertSame(range('a', 'z'), Collection::range('a', 'z')->array());
        $this->assertSame([0, 2, 4, 6, 8, 10], Collection::range(0, 10, 2)->array());
    }
}
