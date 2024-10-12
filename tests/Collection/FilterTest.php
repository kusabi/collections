<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class FilterTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::filter()
     */
    public function testFilter()
    {
        // No callback removes empty values
        $this->assertSame([2 => 1, 4 => 2, 5 => 3], Collection::instance([null, '', 1, null, 2, 3, null])->filter()->array());

        // Callback
        $collection = Collection::range(1, 100)->filter(function ($value) {
            return $value < 10;
        });
        $this->assertSame([1, 2, 3, 4, 5, 6, 7, 8, 9], $collection->array());

        // String callback
        $collection = new Collection([1, 2, 'hello', null]);
        $this->assertSame([2 => 'hello'], $collection->filter('is_string')->array());

        // Filter based on keys
        $collection = new Collection([9, 8, 7, 6, 5, 4, 3, 2, 1]);
        $this->assertSame([6 => 3, 7 => 2, 8 => 1], $collection->filter(function ($value, $key) {
            return $key > 5;
        }, ARRAY_FILTER_USE_BOTH)->array());
    }
}
