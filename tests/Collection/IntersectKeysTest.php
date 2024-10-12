<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class IntersectKeysTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::intersectKeys()
     */
    public function testIntersectKeys()
    {
        $a = ['a' => 1, 'b' => 2, 'c' => 3];
        $b = ['b' => 22, 'c' => 33, 'd' => 44];
        $this->assertSame(['b' => 2, 'c' => 3], array_intersect_key($a, $b));
        $this->assertSame(array_intersect_key($a, $b), Collection::instance($a)->intersectKeys($b)->array());
        $this->assertSame(array_intersect_key($a, $b), Collection::instance($a)->intersectKeys(Collection::instance($b))->array());
    }

    /**
     * @covers \Kusabi\Collection\Collection::intersectKeys()
     */
    public function testIntersectKeysMultiple()
    {
        $a = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
        $b = ['b' => 22, 'c' => 33, 'd' => 44, 'e' => 55];
        $c = ['c' => 333, 'd' => 444, 'e' => 555, 'f' => 666];
        $this->assertSame(['c' => 3, 'd' => 4], array_intersect_key($a, $b, $c));
        $this->assertSame(array_intersect_key($a, $b, $c), Collection::instance($a)->intersectKeys($b, $c)->array());
        $this->assertSame(array_intersect_key($a, $b, $c), Collection::instance($a)->intersectKeys(Collection::instance($b), Collection::instance($c))->array());
    }
}
