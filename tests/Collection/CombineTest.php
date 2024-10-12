<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class CombineTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::combine()
     */
    public function testCombine()
    {
        // Combine with array
        $collection = new Collection(['x', 'y', 'z']);
        $array = ['a', 'b', 'c'];
        $combined = $collection->combine($array);
        $this->assertSame(['x' => 'a', 'y' => 'b', 'z' => 'c'], $combined->array());
        $this->assertSame(['x', 'y', 'z'], $collection->array());
        $this->assertSame(['a', 'b', 'c'], $array);

        // Combine with collection
        $this->assertSame(
            ['x' => 'a', 'y' => 'b', 'z' => 'c'],
            Collection::instance(['x', 'y', 'z'])->combine(Collection::instance(['a', 'b', 'c']))->array()
        );
    }
}
