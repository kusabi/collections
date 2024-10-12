<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class IntersectValuesTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::intersectValues()
     */
    public function testIntersectValues()
    {
        $a = ['a' => 1, 'b' => 2, 'c' => 3, 'key_only_in_a_but_value_in_both' => 'both'];
        $b = ['key_only_in_b_but_value_in_both' => 'both', 'b' => 22, 'c' => 33, 'd' => 44];
        $this->assertSame(['key_only_in_a_but_value_in_both' => 'both'], array_intersect($a, $b));
        $this->assertSame(array_intersect($a, $b), Collection::instance($a)->intersectValues($b)->array());
        $this->assertSame(array_intersect($a, $b), Collection::instance($a)->intersectValues(Collection::instance($b))->array());
    }

    /**
     * @covers \Kusabi\Collection\Collection::intersectValues()
     */
    public function testIntersectValuesMultiple()
    {
        $a = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'key_only_in_a_but_value_in_all' => 'all'];
        $b = ['key_only_in_b_but_value_in_all' => 'all', 'b' => 22, 'c' => 33, 'd' => 44, 'e' => 55];
        $c = ['c' => 333, 'd' => 444, 'key_only_in_c_but_value_in_all' => 'all', 'e' => 555, 'f' => 666];
        $this->assertSame(['key_only_in_a_but_value_in_all' => 'all'], array_intersect($a, $b, $c));
        $this->assertSame(array_intersect($a, $b, $c), Collection::instance($a)->intersectValues($b, $c)->array());
        $this->assertSame(array_intersect($a, $b, $c), Collection::instance($a)->intersectValues(Collection::instance($b), Collection::instance($c))->array());
    }

    /**
     * @covers \Kusabi\Collection\Collection::intersectValues()
     */
    public function testReadmeExamples()
    {
        $this->assertSame([0 => 1, 2 => 3, 4 => 5], Collection::instance([1, 2, 3, 4, 5])->intersectValues([1, 99, 3, 100, 5])->array());
        $this->assertSame([1, 3, 5], Collection::instance([1, 2, 3, 4, 5])->intersectValues([1, 99, 3, 100, 5])->values()->array());
    }
}
