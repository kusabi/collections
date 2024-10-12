<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class FirstTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::first()
     */
    public function testFirst()
    {
        // No callback, no default, no items
        $collection = new Collection();
        $this->assertSame(null, $collection->first());

        // No callback, no default, 1 item
        $collection = new Collection([10]);
        $this->assertSame(10, $collection->first());

        // No callback, no default, x items
        $collection = new Collection([10, 9, 8]);
        $this->assertSame(10, $collection->first());

        // No callback, yes default, no items
        $collection = new Collection();
        $this->assertSame('test', $collection->first(null, 'test'));

        // No callback, yes default, 1 item
        $collection = new Collection([10]);
        $this->assertSame(10, $collection->first(null, 'test'));

        // No callback, yes default, x items
        $collection = new Collection([10, 9, 8]);
        $this->assertSame(10, $collection->first(null, 'test'));

        // Callback that fails to match anything, no default
        $collection = new Collection([1, 2, 3, 4]);
        $this->assertSame(null, $collection->first(function ($value) {
            return $value > 10;
        }));

        // Callback that fails to match anything, with default
        $collection = new Collection([1, 2, 3, 4]);
        $this->assertSame('test', $collection->first(function ($value) {
            return $value > 10;
        }, 'test'));

        // Callback that matches on value
        $collection = new Collection([1, 2, 3, 4]);
        $this->assertSame(3, $collection->first(function ($value) {
            return $value > 2;
        }));

        // Callback that matches on key
        $collection = new Collection([9 => 1, 8 => 2,  7 => 3, 6 => 4]);
        $this->assertSame(2, $collection->first(function ($value, $key) {
            return $key < 9;
        }));
    }

    /**
     * @covers \Kusabi\Collection\Collection::keys()
     * @covers \Kusabi\Collection\Collection::first()
     */
    public function testFirstKey()
    {
        $collection = new Collection(['a' => 1, 'b' => 2, 'c' => 3]);
        $this->assertSame('a', $collection->keys()->first());
    }
}
