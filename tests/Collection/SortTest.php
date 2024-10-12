<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class SortTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::sort()
     */
    public function testExamplesInReadme()
    {
        // [arsort] example
        $this->assertSame([4 => 5, 3 => 4, 2 => 3, 1 => 2, 0 => 1], Collection::instance([1, 2, 3, 4, 5])->sort()->reverse()->array());

        // [asort] example
        $this->assertSame([4 => 1, 3 => 2, 2 => 3, 1 => 4, 0 => 5], Collection::instance([5, 4, 3, 2, 1])->sort()->array());

        // [sort] example
        $this->assertSame([1, 2, 3, 4, 5], Collection::instance([5, 4, 3, 2, 1])->sort()->values()->array());

        // [rsort] example
        $this->assertSame([5, 4, 3, 2, 1], Collection::instance([1, 2, 3, 4, 5])->sort()->reverse()->values()->array());
    }

    /**
     * @covers \Kusabi\Collection\Collection::sort()
     */
    public function testSortCallbackValues()
    {
        $collection = new Collection([
            'a' => 3,
            'b' => 2,
            'c' => 1
        ]);
        $collection->sort(function ($a, $b) {
            return $a <=> $b;
        });
        $this->assertSame(['c' => 1, 'b' => 2, 'a' => 3], $collection->array());
    }

    /**
     * @covers \Kusabi\Collection\Collection::sort()
     */
    public function testSortDefaultsToAscendingValuesWithKeys()
    {
        $collection = new Collection(['a' => 3, 'b' => 2, 'c' => 1]);
        $this->assertSame(['c' => 1, 'b' => 2, 'a' => 3], $collection->sort()->array());
    }
}
