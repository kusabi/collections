<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class DiffKeysTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::diffKeys()
     */
    public function testDiffKeys()
    {
        $a = [1, 2, 3, 5, 6, 7, 8, 9, 10];
        $b = [6, 7, 8, 9, 10, 11, 12, 13];
        $c = [1, 2, 3, 12, 13];
        $d = [1, 2, 3];

        $this->assertSame(array_diff_key($a, $b), Collection::instance($a)->diffKeys($b)->array());
        $this->assertSame(array_diff_key($a, $b, $c, $d), Collection::instance($a)->diffKeys($b, $c, $d)->array());
        $this->assertSame(array_diff_key($a, $b, $c, $d), Collection::instance($a)->diffKeys($b, Collection::instance($c), Collection::instance($d))->array());
        $this->assertSame(array_diff_key($a, $b, $c, $d), Collection::instance($a)->diffKeys(Collection::instance($b), Collection::instance($c), Collection::instance($d))->array());
        $this->assertSame(array_diff_key($a, $b), Collection::instance($a)->diffKeys(Collection::instance($b))->array());
    }
}
