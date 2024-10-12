<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class ArrayTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::array()
     */
    public function testArray()
    {
        $array = [
            'a' => [
                'b' => [
                    'a' => 10,
                    'b' => 11,
                    'c' => 12,
                ]
            ]
        ];
        $collection = new Collection($array);
        $this->assertSame($array, $collection->array());
    }

    /**
     * @covers \Kusabi\Collection\Collection::array()
     */
    public function testExtract()
    {
        $collection = new Collection(['a' => 1, 'b' => 2]);
        extract($collection->array());
        $this->assertSame(1, $a);
        $this->assertSame(2, $b);
    }
}
