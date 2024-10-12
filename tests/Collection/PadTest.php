<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class PadTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::pad()
     */
    public function testPad()
    {
        $a = new Collection([1, 2, 3]);
        $b = $a->pad(10, 'lol');
        $c = $a->pad(-10, 'lol');
        $this->assertSame([1, 2, 3], $a->array());
        $this->assertSame([1, 2, 3, 'lol', 'lol', 'lol', 'lol', 'lol', 'lol', 'lol'], $b->array());
        $this->assertSame(['lol', 'lol', 'lol', 'lol', 'lol', 'lol', 'lol', 1, 2, 3], $c->array());

        $this->assertCount(100, Collection::instance()->pad(100));
    }
}
