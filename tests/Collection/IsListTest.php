<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class IsListTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::isList()
     */
    public function testIsList()
    {
        $this->assertSame(true, Collection::range(0, 100)->isList());
        $this->assertSame(false, Collection::instance(['a' => 1])->isList());
    }
}
