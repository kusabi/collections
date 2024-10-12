<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class IntersectValuesAndKeysTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::intersectValuesAndKeys()
     */
    public function testIntersectValuesAndKeys()
    {
        $a = ['a' => 1, 'b' => 2, 'c' => 3, 'key_only_in_a_but_value_in_both' => 'both', 'key_and_value_in_all' => 'yes'];
        $b = ['key_only_in_b_but_value_in_both' => 'both', 'b' => 22, 'key_and_value_in_all' => 'yes', 'c' => 33, 'd' => 44];
        $this->assertSame(['key_and_value_in_all' => 'yes'], array_intersect_assoc($a, $b));
        $this->assertSame(array_intersect_assoc($a, $b), Collection::instance($a)->intersectValuesAndKeys($b)->array());
        $this->assertSame(array_intersect_assoc($a, $b), Collection::instance($a)->intersectValuesAndKeys(Collection::instance($b))->array());
    }

    /**
     * @covers \Kusabi\Collection\Collection::intersectValuesAndKeys()
     */
    public function testIntersectValuesAndKeysMultiple()
    {
        $a = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'key_only_in_a_but_value_in_all' => 'all', 'key_and_value_in_all' => 'yes'];
        $b = ['key_only_in_b_but_value_in_all' => 'all', 'b' => 22, 'key_and_value_in_all' => 'yes', 'c' => 33, 'd' => 44, 'e' => 55];
        $c = ['c' => 333, 'd' => 444, 'key_only_in_c_but_value_in_all' => 'all', 'e' => 555, 'key_and_value_in_all' => 'yes', 'f' => 666];
        $this->assertSame(['key_and_value_in_all' => 'yes'], array_intersect_assoc($a, $b, $c));
        $this->assertSame(array_intersect_assoc($a, $b, $c), Collection::instance($a)->intersectValuesAndKeys($b, $c)->array());
        $this->assertSame(array_intersect_assoc($a, $b, $c), Collection::instance($a)->intersectValuesAndKeys(Collection::instance($b), Collection::instance($c))->array());
    }

    /**
     * @covers \Kusabi\Collection\Collection::intersectValuesAndKeys()
     */
    public function testReadmeExamples()
    {
        $this->assertSame(['c' => 3], Collection::instance(['a' => 1, 'b' => 2, 'c' => 3])->intersectValuesAndKeys(['b' => 22, 'c' => 3, 'd' => 44])->array());
    }
}
