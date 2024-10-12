<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class CountTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::count()
     */
    public function testCount()
    {
        $collection = new Collection();
        $this->assertCount(0, $collection);
        $collection[] = 1;
        $collection[] = 2;
        $collection[] = 3;
        $this->assertCount(3, $collection);
    }
}
