<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class InflateTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::inflate()
     */
    public function testInflate()
    {
        $collection = new Collection(['a.b.c' => 1]);
        $inflated = $collection->inflate();
        $this->assertSame([
            'a' => [
                'b' => [
                    'c' => 1,
                ]
            ]
        ], $inflated->array());
        $this->assertSame([
            'a.b.c' => 1
        ], $collection->array());
        $this->assertNotSame($collection, $inflated);
    }
}
