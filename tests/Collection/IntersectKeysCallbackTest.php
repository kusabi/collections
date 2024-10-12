<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class IntersectKeysCallbackTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::intersectKeysCallback()
     */
    public function testIntersectKeysCallback()
    {
        $a = ['a' => 1, 'b' => 2, 'c' => 3, 'z_something' => 50];
        $b = ['b' => 22, 'c' => 33, 'd' => 44, 'z_else' => 500];
        $callback = function ($a, $b) {
            $a = substr($a, 0, 1);
            $b = substr($b, 0, 1);
            return $a <=> $b;
        };
        $this->assertSame(['b' => 2, 'c' => 3,  'z_something' => 50], array_intersect_ukey($a, $b, $callback));
        $this->assertSame(array_intersect_ukey($a, $b, $callback), Collection::instance($a)->intersectKeysCallback($callback, $b)->array());
        $this->assertSame(array_intersect_ukey($a, $b, $callback), Collection::instance($a)->intersectKeysCallback($callback, Collection::instance($b))->array());
    }

    /**
     * @covers \Kusabi\Collection\Collection::intersectKeysCallback()
     */
    public function testIntersectKeysCallbackMultiple()
    {
        $a = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4,  'z_something' => 50];
        $b = ['b' => 22, 'c' => 33, 'd' => 44, 'e' => 55, 'z_else' => 500];
        $c = ['c' => 22, 'd' => 33, 'e' => 44, 'f' => 55, 'z_other' => 5000];
        $callback = function ($a, $b) {
            $a = substr($a, 0, 1);
            $b = substr($b, 0, 1);
            return $a <=> $b;
        };
        $this->assertSame(['c' => 3, 'd' => 4,  'z_something' => 50], array_intersect_ukey($a, $b, $c, $callback));
        $this->assertSame(array_intersect_ukey($a, $b, $c, $callback), Collection::instance($a)->intersectKeysCallback($callback, $b, $c)->array());
        $this->assertSame(array_intersect_ukey($a, $b, $c, $callback), Collection::instance($a)->intersectKeysCallback($callback, Collection::instance($b), Collection::instance($c))->array());
    }
}
