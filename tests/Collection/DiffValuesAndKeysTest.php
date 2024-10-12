<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class DiffValuesAndKeysTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::diffValuesAndKeys()
     */
    public function testDiffValuesAndKeys()
    {
        $a = [1, 2, 3, 5, 6, 7, 8, 9, 10];
        $b = [6, 7, 8, 9, 10, 11, 12, 13];
        $c = [1, 2, 3, 12, 13];
        $d = [1, 2, 3];

        $this->assertSame(array_diff_assoc($a, $b), Collection::instance($a)->diffValuesAndKeys($b)->array());
        $this->assertSame(array_diff_assoc($a, $b, $c, $d), Collection::instance($a)->diffValuesAndKeys($b, $c, $d)->array());
        $this->assertSame(array_diff_assoc($a, $b, $c, $d), Collection::instance($a)->diffValuesAndKeys($b, Collection::instance($c), Collection::instance($d))->array());
        $this->assertSame(array_diff_assoc($a, $b, $c, $d), Collection::instance($a)->diffValuesAndKeys(Collection::instance($b), Collection::instance($c), Collection::instance($d))->array());
        $this->assertSame(array_diff_assoc($a, $b), Collection::instance($a)->diffValuesAndKeys(Collection::instance($b))->array());
    }

    /**
     * @covers \Kusabi\Collection\Collection::diffValuesAndKeys()
     */
    public function testReadmeExamples()
    {
        $this->assertSame([1, 2, 3, 4, 5, 6], Collection::instance([1, 2, 3, 4, 5, 6])->diffValuesAndKeys([3, 4, 5])->array());

        $this->assertSame(['a' => 1, 'c' => 3], Collection::instance(['a' => 1, 'b' => 2, 'c' => 3])->diffValuesAndKeys(['a' => 10, 'b' => 2, 'd' => 3])->array());
    }
}
