<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class ReverseTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::reverse()
     */
    public function testReverse()
    {
        $collection = new Collection(['a' => 1, 1 => 2, 'c' => 'd']);
        $reversed = $collection->reverse();
        $this->assertSame(['c' => 'd', 1 => 2, 'a' => 1], $reversed->array());
        $this->assertSame(['a' => 1, 1 => 2, 'c' => 'd'], $collection->array());
        $this->assertNotSame($collection, $reversed);
    }
}
