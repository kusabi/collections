<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class LastTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::last()
     */
    public function testLast()
    {
        // No callback, no default, no items
        $collection = new Collection();
        $this->assertSame(null, $collection->last());

        // No callback, no default, 1 item
        $collection = new Collection([10]);
        $this->assertSame(10, $collection->last());

        // No callback, no default, x items
        $collection = new Collection([10, 9, 8]);
        $this->assertSame(8, $collection->last());

        // No callback, yes default, no items
        $collection = new Collection();
        $this->assertSame('test', $collection->last(null, 'test'));

        // No callback, yes default, 1 item
        $collection = new Collection([10]);
        $this->assertSame(10, $collection->last(null, 'test'));

        // No callback, yes default, x items
        $collection = new Collection([10, 9, 8]);
        $this->assertSame(8, $collection->last(null, 'test'));

        // Callback that fails to match anything, no default
        $collection = new Collection([1, 2, 3, 4]);
        $this->assertSame(null, $collection->last(function ($value) {
            return $value > 10;
        }));

        // Callback that fails to match anything, with default
        $collection = new Collection([1, 2, 3, 4]);
        $this->assertSame('test', $collection->last(function ($value) {
            return $value > 10;
        }, 'test'));

        // Callback that matches on value
        $collection = new Collection([1, 2, 3, 4]);
        $this->assertSame(3, $collection->last(function ($value) {
            return $value < 4;
        }));

        // Callback that matches on key
        $collection = new Collection([9 => 1, 8 => 2,  7 => 3, 6 => 4]);
        $this->assertSame(3, $collection->last(function ($value, $key) {
            return $key > 6;
        }));
    }

    /**
     * @covers \Kusabi\Collection\Collection::last()
     * @covers \Kusabi\Collection\Collection::keys()
     */
    public function testLastKey()
    {
        $collection = new Collection(['a' => 1, 'b' => 2, 'c' => 3]);
        $this->assertSame('c', $collection->keys()->last());
    }
}
