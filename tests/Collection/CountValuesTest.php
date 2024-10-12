<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class CountValuesTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::countValues()
     */
    public function testCountValues()
    {
        $collection = new Collection([1, 2, 3, 1, 2, 4, 'a', 'a', 1]);

        $appearances = $collection->countValues(); // [1 => 3, 2 => 2, 3 => 1, 4 => 1, 'a' => 2]

        $this->assertInstanceOf(Collection::class, $appearances);

        $this->assertSame([1 => 3, 2 => 2, 3 => 1, 4 => 1, 'a' => 2], $appearances->array());
    }
}
