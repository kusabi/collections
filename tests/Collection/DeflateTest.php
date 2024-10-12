<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class DeflateTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::deflate()
     */
    public function testDeflateKeepKeys()
    {
        $collection = new Collection();
        $collection['a.b.c'] = 1;
        $collection['a.c.a'] = 2;
        $this->assertSame([
            'a' => [
                'b' => [
                    'c' => 1
                ],
                'c' => [
                    'a' => 2
                ]
            ]
        ], $collection->array());

        $deflated = $collection->deflate();
        $this->assertSame([
            'a.b.c' => 1,
            'a.c.a' => 2,
        ], $deflated->array());

        $this->assertSame([
            'a' => [
                'b' => [
                    'c' => 1
                ],
                'c' => [
                    'a' => 2
                ]
            ]
        ], $collection->array());

        $this->assertNotSame($collection, $deflated);
    }

    /**
     * @covers \Kusabi\Collection\Collection::deflate()
     */
    public function testDeflateNoKeepKeys()
    {
        $collection = new Collection();
        $collection['a.b.c'] = 1;
        $collection['a.c.a'] = 2;
        $this->assertSame([
            'a' => [
                'b' => [
                    'c' => 1
                ],
                'c' => [
                    'a' => 2
                ]
            ]
        ], $collection->array());

        $deflated = $collection->deflate(false);
        $this->assertSame([
            0 => 1,
            1 => 2,
        ], $deflated->array());

        $this->assertSame([
            'a' => [
                'b' => [
                    'c' => 1
                ],
                'c' => [
                    'a' => 2
                ]
            ]
        ], $collection->array());

        $this->assertNotSame($collection, $deflated);
    }
}
