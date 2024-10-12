<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class IterableTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::getIterator()
     */
    public function testIterable()
    {
        $array = ['a' => 1, 'b' => 2, 'c' => 3];
        $collection = new Collection($array);

        foreach ($collection as $key => $value) {
            $this->assertSame(current($array), $value);
            $this->assertSame(key($array), $key);
            next($array);
        }

        $this->assertSame($array, iterator_to_array($collection));
    }
}
