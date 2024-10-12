<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class CastArrayTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::castArray()
     */
    public function testCastArray()
    {
        $this->assertSame([1, 2, 3], Collection::castArray([1, 2, 3]));

        $this->assertSame([1], Collection::castArray(1));

        $this->assertSame(['h', 'e', 'l', 'l', 'o'], Collection::castArray('hello'));

        $this->assertSame([1, 2, 3, 4], Collection::castArray(new Collection([1, 2, 3, 4])));
    }
}
