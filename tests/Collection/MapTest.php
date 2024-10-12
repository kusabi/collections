<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class MapTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::map()
     */
    public function testMapNestedWithKey()
    {
        $collection = new Collection();
        $collection['a'] = 1;
        $collection['b.a'] = 2;
        $collection['b.b'] = 3;
        $collection['c.z'] = 4;

        $mapped = $collection->map(function ($value, $key) {
            return $key.'-'.$value;
        }, true);

        $this->assertSame('a-1', $mapped['a']);
        $this->assertSame('b.a-2', $mapped['b.a']);
        $this->assertSame('b.b-3', $mapped['b.b']);
        $this->assertSame('c.z-4', $mapped['c.z']);

        $this->assertSame([
            'a' => 'a-1',
            'b' => [
                'a' => 'b.a-2',
                'b' => 'b.b-3',
            ],
            'c' => [
                'z' => 'c.z-4',
            ],
        ], $mapped->array());
    }

    /**
     * @covers \Kusabi\Collection\Collection::map()
     */
    public function testMapNestedWithoutKey()
    {
        $collection = new Collection();
        $collection['a'] = 1;
        $collection['b.a'] = 2;
        $collection['b.b'] = 3;
        $collection['c.z'] = 4;

        $mapped = $collection->map(function ($value) {
            return $value * 10;
        }, true);

        $this->assertSame(10, $mapped['a']);
        $this->assertSame(20, $mapped['b.a']);
        $this->assertSame(30, $mapped['b.b']);
        $this->assertSame(40, $mapped['c.z']);

        $this->assertSame([
            'a' => 10,
            'b' => [
                'a' => 20,
                'b' => 30,
            ],
            'c' => [
                'z' => 40,
            ],
        ], $mapped->array());
    }

    /**
     * @covers \Kusabi\Collection\Collection::map()
     */
    public function testMapWithKey()
    {
        $collection = new Collection([
            'a' => 1,
            'b' => 2,
            'c' => 3,
        ]);

        $mapped = $collection->map(function ($value, $key) {
            return $key.'-'.$value;
        });

        $this->assertSame('a-1', $mapped['a']);
        $this->assertSame('b-2', $mapped['b']);
        $this->assertSame('c-3', $mapped['c']);

        $this->assertSame([
            'a' => 'a-1',
            'b' => 'b-2',
            'c' => 'c-3',
        ], $mapped->array());
    }

    /**
     * @covers \Kusabi\Collection\Collection::map()
     */
    public function testMapWithoutKey()
    {
        $collection = new Collection([
            'a' => 1,
            'b' => 2,
            'c' => 3,
        ]);

        $mapped = $collection->map(function ($value) {
            return $value * 10;
        });

        $this->assertSame(10, $mapped['a']);
        $this->assertSame(20, $mapped['b']);
        $this->assertSame(30, $mapped['c']);

        $this->assertSame([
            'a' => 10,
            'b' => 20,
            'c' => 30,
        ], $mapped->array());
    }
}
