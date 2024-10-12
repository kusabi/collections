<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class IsEmptyTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::isEmpty()
     */
    public function testIsEmpty()
    {
        $collection = new Collection();
        $this->assertTrue($collection->isEmpty());
        $collection[] = 1;
        $this->assertFalse($collection->isEmpty());
        unset($collection[0]);
        $this->assertTrue($collection->isEmpty());
    }
}
