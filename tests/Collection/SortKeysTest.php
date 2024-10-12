<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class SortKeysTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::sortKeys()
     */
    public function testSortKeys()
    {
        $baseArray = [1, 2, 3, 4, 5, 9, 8, 7, 6, 'a' => 'a', 'b' => 'b', 'c' => 'c', 'z' => 'z', 'x' => 'x', 'y' => 'y'];
        foreach ([SORT_REGULAR, SORT_NUMERIC, SORT_STRING, SORT_LOCALE_STRING, SORT_NATURAL, SORT_FLAG_CASE] as $flag) {
            $collection = new Collection($baseArray);
            $sortedAsc = $baseArray;
            ksort($sortedAsc, $flag);
            $this->assertSame($sortedAsc, $collection->sortKeys(SORT_ASC, $flag)->array());

            $collection = new Collection($baseArray);
            $sortedDes = $baseArray;
            krsort($sortedDes, $flag);
            $this->assertSame($sortedDes, $collection->sortKeys(SORT_DESC, $flag)->array());
        }

        $this->assertSame(['a' => 1, 'b' => 99, 'c' => [1, 2, 3]], Collection::instance(['c' => [1, 2, 3], 'b' => 99, 'a' => 1])->sortKeys()->array());
    }
}
