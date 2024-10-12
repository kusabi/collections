<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class IntersectValuesAndKeysCallbackTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::intersectValuesAndKeysCallback()
     */
    public function testIntersectValuesAndKeysCallback()
    {
        $a = ['a' => 1, 'b' => 2, 'c' => 3, 'value_in_all_but_key_different_except_first_letter_in_all_a' => 'all'];
        $b = ['value_in_all_but_key_different_except_first_letter_in_all_b' => 'all', 'b' => 22, 'key_and_value_in_all' => 'yes', 'c' => 33, 'd' => 44];

        $callback = function ($a, $b) {
            $a = substr($a, 0, 1);
            $b = substr($b, 0, 1);
            return $a <=> $b;
        };

        $this->assertSame(['value_in_all_but_key_different_except_first_letter_in_all_a' => 'all'], array_intersect_uassoc($a, $b, $callback));
        $this->assertSame(array_intersect_uassoc($a, $b, $callback), Collection::instance($a)->intersectValuesAndKeysCallback($callback, $b)->array());
        $this->assertSame(array_intersect_uassoc($a, $b, $callback), Collection::instance($a)->intersectValuesAndKeysCallback($callback, Collection::instance($b))->array());
    }

    /**
     * @covers \Kusabi\Collection\Collection::intersectValuesAndKeysCallback()
     */
    public function testIntersectValuesAndKeysCallbackMultiple()
    {
        $a = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'value_in_all_but_key_different_except_first_letter_in_all_a' => 'all'];
        $b = ['value_in_all_but_key_different_except_first_letter_in_all_b' => 'all', 'c' => 33, 'd' => 44, 'e' => 55];
        $c = ['c' => 333, 'd' => 444, 'value_in_all_but_key_different_except_first_letter_in_all_c' => 'all', 'e' => 555, 'f' => 666];

        $callback = function ($a, $b) {
            $a = substr($a, 0, 1);
            $b = substr($b, 0, 1);
            return $a <=> $b;
        };

        $this->assertSame(['value_in_all_but_key_different_except_first_letter_in_all_a' => 'all'], array_intersect_uassoc($a, $b, $c, $callback));
        $this->assertSame(array_intersect_uassoc($a, $b, $c, $callback), Collection::instance($a)->intersectValuesAndKeysCallback($callback, $b, $c)->array());
        $this->assertSame(array_intersect_uassoc($a, $b, $c, $callback), Collection::instance($a)->intersectValuesAndKeysCallback($callback, Collection::instance($b), Collection::instance($c))->array());
    }

    /**
     * @covers \Kusabi\Collection\Collection::intersectValuesAndKeysCallback()
     */
    public function testReadmeExamples()
    {
        $a = ['alpha' => 1, 'beta' => 2, 'gamma' => 3];
        $b = ['alpha' => 10, 'banana' => 2, 'gamma' => 3];

        $key_compare_function = function ($a, $b) {
            // Take only the first letter of the key
            $a = substr($a, 0, 1);
            $b = substr($b, 0, 1);
            return $a <=> $b;
        };

        $this->assertSame(['beta' => 2, 'gamma' => 3], Collection::instance($a)->intersectValuesAndKeysCallback($key_compare_function, $b)->array());
    }
}
