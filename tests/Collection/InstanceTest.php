<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class InstanceTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::instance()
     */
    public function testInstanceWithNoParameter()
    {
        $collection = Collection::instance();
        $this->assertEmpty($collection);
        $this->assertCount(0, $collection);
    }

    /**
     * @covers \Kusabi\Collection\Collection::instance()
     */
    public function testInstanceWithParameter()
    {
        $collection = Collection::instance([1, 2, 3]);
        $this->assertNotEmpty($collection);
        $this->assertCount(3, $collection);
        $this->assertSame(1, $collection[0]);
        $this->assertSame(2, $collection[1]);
        $this->assertSame(3, $collection[2]);

        $this->assertSame(['h', 'e', 'l', 'l', 'o'], Collection::instance('hello')->array());
        $this->assertSame([1], Collection::instance(1)->array());

        $this->assertSame('olleh', Collection::instance('hello')->reverse()->implode());
    }
}
