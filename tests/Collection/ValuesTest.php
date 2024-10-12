<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class ValuesTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::values()
     */
    public function testValues()
    {
        $collection = new Collection(['a' => 1, 'b' => 2, 'c' => 3]);
        $this->assertSame([1, 2, 3], $collection->values()->array());
    }
}
