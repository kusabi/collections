<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class SliceTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::slice()
     */
    public function testSlice()
    {
        $collection = Collection::range('a', 'j')->combine(Collection::range(1, 10)->reverse());
        $bcd = $collection->slice(1, 3);
        $this->assertSame(['a' => 10, 'b' => 9, 'c' => 8, 'd' => 7, 'e' => 6, 'f' => 5, 'g' => 4, 'h' => 3, 'i' => 2, 'j' => 1], $collection->array());
        $this->assertSame(['b' => 9, 'c' => 8, 'd' => 7], $bcd->array());
    }
}
