<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class DiffValuesTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::diffValues()
     */
    public function testDiffValues()
    {
        $a = [1, 2, 3, 5, 6, 7, 8, 9, 10];
        $b = [6, 7, 8, 9, 10, 11, 12, 13];
        $c = [1, 2, 3, 12, 13];
        $d = [1, 2, 3];

        $this->assertSame(array_diff($a, $b), Collection::instance($a)->diffValues($b)->array());
        $this->assertSame(array_diff($a, $b, $c, $d), Collection::instance($a)->diffValues($b, $c, $d)->array());
        $this->assertSame(array_diff($a, $b, $c, $d), Collection::instance($a)->diffValues($b, Collection::instance($c), Collection::instance($d))->array());
        $this->assertSame(array_diff($a, $b, $c, $d), Collection::instance($a)->diffValues(Collection::instance($b), Collection::instance($c), Collection::instance($d))->array());
        $this->assertSame(array_diff($a, $b), Collection::instance($a)->diffValues(Collection::instance($b))->array());
    }

    /**
     * @covers \Kusabi\Collection\Collection::diffValues()
     */
    public function testReadmeExamples()
    {
        $this->assertSame([3 => 4, 4 => 5, 5 => 6], Collection::instance([1, 2, 3, 4, 5, 6])->diffKeys([3, 4, 5])->array());
    }
}
