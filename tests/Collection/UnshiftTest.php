<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class UnshiftTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::unshift()
     */
    public function testUnshift()
    {
        $collection = new Collection([1, 2, 3]);
        $collection->unshift(4);
        $this->assertSame([4, 1, 2, 3], $collection->array());

        $collection->unshift(5, 6, 7, 8);
        $this->assertSame([5, 6, 7, 8, 4, 1, 2, 3], $collection->array());
    }
}
