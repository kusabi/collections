<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class ShiftTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::shift()
     */
    public function testShift()
    {
        $collection = new Collection([1, 2, 3]);
        $shifted = $collection->shift();
        $this->assertSame(1, $shifted);
        $this->assertSame([2, 3], $collection->array());

        $collection = new Collection();
        $popped = $collection->shift();
        $this->assertSame(null, $popped);
        $this->assertSame([], $collection->array());
    }
}
