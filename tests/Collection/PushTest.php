<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class PushTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::push()
     */
    public function testPush()
    {
        $collection = new Collection([1, 2, 3]);
        $collection->push(4);
        $this->assertSame([1, 2, 3, 4], $collection->array());

        $collection->push(5, 6, 7, 8);
        $this->assertSame([1, 2, 3, 4, 5, 6, 7, 8], $collection->array());
    }
}
