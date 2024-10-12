<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class IsListTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::isList()
     */
    public function testIsListEmpty()
    {
        $this->assertSame(true, Collection::instance()->isList());
    }

    /**
     * @covers \Kusabi\Collection\Collection::isList()
     */
    public function testIsListHasMap()
    {
        $this->assertSame(false, Collection::instance(['a' => 1])->isList());
    }

    /**
     * @covers \Kusabi\Collection\Collection::isList()
     */
    public function testIsListList()
    {
        $this->assertSame(true, Collection::range(0, 100)->isList());
    }
}
