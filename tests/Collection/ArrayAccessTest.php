<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class ArrayAccessTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::offsetGet()
     */
    public function testGetNestedKey()
    {
        $collection = new Collection([
            'a' => [
                'b' => [
                    'a' => 10,
                    'b' => 11,
                    'c' => 12,
                ]
            ]
        ]);
        $this->assertSame(10, $collection['a.b.a']);
        $this->assertSame(11, $collection['a.b.b']);
        $this->assertSame(12, $collection['a.b.c']);
    }

    /**
     * @covers \Kusabi\Collection\Collection::offsetExists()
     */
    public function testOffsetExists()
    {
        $collection = new Collection(['a' => 'b']);
        $this->assertTrue(isset($collection['a']));
        $this->assertFalse(isset($collection['b']));
        unset($collection['a']);
        $this->assertFalse(isset($collection['a']));
    }

    /**
     * @covers \Kusabi\Collection\Collection::offsetExists()
     */
    public function testOffsetExistsNestKey()
    {
        $collection = new Collection([
            'a' => [
                'b' => [
                    'a' => 10,
                    'b' => 11,
                    'c' => 12,
                ]
            ]
        ]);
        $this->assertTrue(isset($collection['a.b.a']));
        $this->assertTrue(isset($collection['a.b.b']));
        $this->assertTrue(isset($collection['a.b.c']));
        $this->assertFalse(isset($collection['a.b.d']));
        $this->assertFalse(isset($collection['a.a']));
        unset($collection['a.b.c']);
        $this->assertFalse(isset($collection['a.b.c']));
    }

    /**
     * @covers \Kusabi\Collection\Collection::offsetGet()
     */
    public function testOffsetGet()
    {
        $collection = new Collection(['a' => 'b']);
        $this->assertSame('b', $collection['a']);
    }

    /**
     * @covers \Kusabi\Collection\Collection::offsetSet()
     *
     */
    public function testOffsetSet()
    {
        $collection = new Collection();
        $this->assertCount(0, $collection);
        $collection[] = 1;
        $collection[] = 2;
        $collection[] = 3;
        $collection['test'] = 4;
        $collection[2] = 99;
        $this->assertCount(4, $collection);
        $this->assertSame(1, $collection[0]);
        $this->assertSame(2, $collection[1]);
        $this->assertSame(99, $collection[2]);
        $this->assertSame(4, $collection['test']);
    }

    /**
     * @covers \Kusabi\Collection\Collection::offsetSet()
     */
    public function testSetNestedKey()
    {
        $collection = new Collection();
        $collection['a.b.a'] = 10;
        $collection['a.b.b'] = 10;
        $collection['a.b.c'] = 10;
        $this->assertSame([
            'a' => [
                'b' => [
                    'a' => 10,
                    'b' => 10,
                    'c' => 10,
                ]
            ]
        ], iterator_to_array($collection));
    }

    /**
     * @covers \Kusabi\Collection\Collection::offsetUnset()
     */
    public function testUnset()
    {
        $collection = new Collection(['a' => 'b']);
        $this->assertTrue(isset($collection['a']));
        $this->assertFalse(isset($collection['b']));
        unset($collection['a']);
        $this->assertFalse(isset($collection['a']));
    }
}
