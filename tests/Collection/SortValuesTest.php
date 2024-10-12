<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class SortValuesTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::sortValues()
     */
    public function testSortValues()
    {
        $baseArray = [1, 2, 3, 4, 5, 9, 8, 7, 6, 'a' => 'a', 'b' => 'b', 'c' => 'c', 'z' => 'z', 'x' => 'x', 'y' => 'y'];

        // Default ascending is keep keys
        $collection = new Collection($baseArray);
        $sorted = $baseArray;
        asort($sorted);
        $this->assertSame($sorted, $collection->sortValues()->array());

        // Default descending is keep keys
        $collection = new Collection($baseArray);
        $sorted = $baseArray;
        arsort($sorted);
        $this->assertSame($sorted, $collection->sortValues(SORT_DESC)->array());

        // Test with sort modes
        foreach ([SORT_REGULAR, SORT_NUMERIC, SORT_STRING, SORT_LOCALE_STRING, SORT_NATURAL, SORT_FLAG_CASE] as $flag) {

            // Ascending, lose keys
            $collection = new Collection($baseArray);
            $sorted = $baseArray;
            sort($sorted, $flag);
            $this->assertSame($sorted, $collection->sortValues(SORT_ASC, false, $flag)->array());

            // Ascending, keep keys
            $collection = new Collection($baseArray);
            $sorted = $baseArray;
            asort($sorted, $flag);
            $this->assertSame($sorted, $collection->sortValues(SORT_ASC, true, $flag)->array());

            // Descending, lose keys
            $collection = new Collection($baseArray);
            $sorted = $baseArray;
            rsort($sorted, $flag);
            $this->assertSame($sorted, $collection->sortValues(SORT_DESC, false, $flag)->array());

            // Descending, keep keys
            $collection = new Collection($baseArray);
            $sorted = $baseArray;
            arsort($sorted, $flag);
            $this->assertSame($sorted, $collection->sortValues(SORT_DESC, true, $flag)->array());
        }
    }
}
