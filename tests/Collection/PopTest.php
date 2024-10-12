<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class PopTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::pop()
     */
    public function testPop()
    {
        $collection = new Collection([1, 2, 3]);
        $popped = $collection->pop();
        $this->assertSame(3, $popped);
        $this->assertSame([1, 2], $collection->array());

        $collection = new Collection();
        $popped = $collection->pop();
        $this->assertSame(null, $popped);
        $this->assertSame([], $collection->array());
    }
}
