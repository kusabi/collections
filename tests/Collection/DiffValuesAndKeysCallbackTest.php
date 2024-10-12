<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class DiffValuesAndKeysCallbackTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::diffValuesAndKeysCallback()
     */
    public function testDiffValuesAndKeysCallback()
    {
        $a = ['a' => 1, 'b' => 2, 'c' => 3, 'value_in_all_but_key_different_except_first_letter_in_all_a' => 'all'];
        $b = ['value_in_all_but_key_different_except_first_letter_in_all_b' => 'all', 'b' => 22, 'key_and_value_in_all' => 'yes', 'c' => 33, 'd' => 44];

        $callback = function ($a, $b) {
            $a = substr($a, 0, 1);
            $b = substr($b, 0, 1);
            return $a <=> $b;
        };

        $this->assertSame(['a' => 1, 'b' => 2, 'c' => 3], array_diff_uassoc($a, $b, $callback));
        $this->assertSame(array_diff_uassoc($a, $b, $callback), Collection::instance($a)->diffValuesAndKeysCallback($callback, $b)->array());
        $this->assertSame(array_diff_uassoc($a, $b, $callback), Collection::instance($a)->diffValuesAndKeysCallback($callback, Collection::instance($b))->array());
    }

    /**
     * @covers \Kusabi\Collection\Collection::diffValuesAndKeysCallback()
     */
    public function testDiffValuesAndKeysCallbackMultiple()
    {
        $a = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'value_in_all_but_key_different_except_first_letter_in_all_a' => 'all'];
        $b = ['value_in_all_but_key_different_except_first_letter_in_all_b' => 'all', 'c' => 33, 'd' => 44, 'e' => 55];
        $c = ['c' => 333, 'd' => 444, 'value_in_all_but_key_different_except_first_letter_in_all_c' => 'all', 'e' => 555, 'f' => 666];

        $callback = function ($a, $b) {
            $a = substr($a, 0, 1);
            $b = substr($b, 0, 1);
            return $a <=> $b;
        };

        $this->assertSame(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4], array_diff_uassoc($a, $b, $c, $callback));
        $this->assertSame(array_diff_uassoc($a, $b, $c, $callback), Collection::instance($a)->diffValuesAndKeysCallback($callback, $b, $c)->array());
        $this->assertSame(array_diff_uassoc($a, $b, $c, $callback), Collection::instance($a)->diffValuesAndKeysCallback($callback, Collection::instance($b), Collection::instance($c))->array());
    }

    /**
     * @covers \Kusabi\Collection\Collection::diffValuesAndKeysCallback()
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

        $this->assertSame(['alpha' => 1], Collection::instance($a)->diffValuesAndKeysCallback($key_compare_function, $b)->array());
    }
}
