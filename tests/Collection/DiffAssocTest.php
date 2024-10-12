<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class DiffAssocTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::diffAssoc()
     */
    public function testDiffAssoc()
    {
        $a = [1, 2, 3, 5, 6, 7, 8, 9, 10];
        $b = [6, 7, 8, 9, 10, 11, 12, 13];
        $c = [1, 2, 3, 12, 13];
        $d = [1, 2, 3];

        $this->assertSame(array_diff_assoc($a, $b), Collection::instance($a)->diffAssoc($b)->array());
        $this->assertSame(array_diff_assoc($a, $b, $c, $d), Collection::instance($a)->diffAssoc($b, $c, $d)->array());
        $this->assertSame(array_diff_assoc($a, $b, $c, $d), Collection::instance($a)->diffAssoc($b, Collection::instance($c), Collection::instance($d))->array());
        $this->assertSame(array_diff_assoc($a, $b, $c, $d), Collection::instance($a)->diffAssoc(Collection::instance($b), Collection::instance($c), Collection::instance($d))->array());
        $this->assertSame(array_diff_assoc($a, $b), Collection::instance($a)->diffAssoc(Collection::instance($b))->array());
    }
}
