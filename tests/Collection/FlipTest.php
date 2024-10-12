<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class FlipTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::flip()
     */
    public function testFlip()
    {
        $collection = new Collection(['a', 'b', 'c']);
        $this->assertSame(['a' => 0, 'b' => 1, 'c' => 2], $collection->flip()->array());

        $collection = new Collection(['a', 'b', 'c', 'a']);
        $this->assertSame(['a' => 3, 'b' => 1, 'c' => 2], $collection->flip()->array());
        $this->assertSame([3 => 'a', 1 => 'b', 2 => 'c'], $collection->flip()->flip()->array());
    }
}
