<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class ContainsTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::contains()
     */
    public function testContains()
    {
        $collection = new Collection([4, 5, 6]);
        $this->assertSame(false, $collection->contains(1));
        $this->assertSame(false, $collection->contains(2));
        $this->assertSame(false, $collection->contains(3));
        $this->assertSame(true, $collection->contains(4));
        $this->assertSame(true, $collection->contains(5));
        $this->assertSame(true, $collection->contains(6));
    }
}
