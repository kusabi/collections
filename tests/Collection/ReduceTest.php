<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class ReduceTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::reduce()
     */
    public function testReduce()
    {
        $this->assertSame(3628800, Collection::range(1, 10)->reduce(function ($carry, $value) {
            return $carry * $value;
        }, 1));
    }
}
