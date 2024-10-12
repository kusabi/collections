<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class DiffKeysCallbackTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::diffKeysCallback()
     */
    public function testDiffKeysCallback()
    {
        $a = ['a' => 1, 'b' => 2, 'c' => 3, 'z_something' => 50];
        $b = ['b' => 22, 'c' => 33, 'd' => 44, 'z_else' => 500];
        $callback = function ($a, $b) {
            $a = substr($a, 0, 1);
            $b = substr($b, 0, 1);
            return $a <=> $b;
        };
        $this->assertSame(['a' => 1], array_diff_ukey($a, $b, $callback));
        $this->assertSame(array_diff_ukey($a, $b, $callback), Collection::instance($a)->diffKeysCallback($callback, $b)->array());
        $this->assertSame(array_diff_ukey($a, $b, $callback), Collection::instance($a)->diffKeysCallback($callback, Collection::instance($b))->array());
    }

    /**
     * @covers \Kusabi\Collection\Collection::diffKeysCallback()
     */
    public function testDiffKeysCallbackMultiple()
    {
        $a = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4,  'z_something' => 50];
        $b = ['b' => 22, 'c' => 33, 'd' => 44, 'e' => 55, 'z_else' => 500];
        $c = ['c' => 22, 'd' => 33, 'e' => 44, 'f' => 55, 'z_other' => 5000];
        $callback = function ($a, $b) {
            $a = substr($a, 0, 1);
            $b = substr($b, 0, 1);
            return $a <=> $b;
        };
        $this->assertSame(['a' => 1], array_diff_ukey($a, $b, $c, $callback));
        $this->assertSame(array_diff_ukey($a, $b, $c, $callback), Collection::instance($a)->diffKeysCallback($callback, $b, $c)->array());
        $this->assertSame(array_diff_ukey($a, $b, $c, $callback), Collection::instance($a)->diffKeysCallback($callback, Collection::instance($b), Collection::instance($c))->array());
    }
}
