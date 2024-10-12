<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class ConstructorTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::__construct()
     */
    public function testConstructorWithNoParameter()
    {
        $collection = new Collection();
        $this->assertEmpty($collection);
        $this->assertCount(0, $collection);
    }

    /**
     * @covers \Kusabi\Collection\Collection::__construct()
     */
    public function testConstructorWithParameter()
    {
        $collection = new Collection([1, 2, 3]);
        $this->assertNotEmpty($collection);
        $this->assertCount(3, $collection);
        $this->assertSame(1, $collection[0]);
        $this->assertSame(2, $collection[1]);
        $this->assertSame(3, $collection[2]);
    }
}
