<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class FillTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::fill()
     */
    public function testFill()
    {
        $this->assertSame(array_fill(0, 20, 'a'), Collection::fill(0, 20, 'a')->array());
    }
}
