<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class SortValuesCallbackTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::sortValuesCallback()
     */
    public function testSortValuesCallback()
    {
        $baseArray = [1, 2, 3, 4, 5, 9, 8, 7, 6, 'a' => 'a', 'b' => 'b', 'c' => 'c', 'z' => 'z', 'x' => 'x', 'y' => 'y'];

        $callback = function ($a, $b) {
            $aSpecial = $a >= 4 && $a <= 8;
            $bSpecial = $b >= 4 && $b <= 8;

            if ($aSpecial && !$bSpecial) {
                return -1;
            }

            if ($bSpecial && !$aSpecial) {
                return 1;
            }

            return $a <=> $b;
        };

        // Defaults to keep keys
        $collection = new Collection($baseArray);
        $sorted = $baseArray;
        uasort($sorted, $callback);
        $this->assertSame($sorted, $collection->sortValuesCallback($callback)->array());

        // Lose keys
        $collection = new Collection($baseArray);
        $sorted = $baseArray;
        usort($sorted, $callback);
        $this->assertSame($sorted, $collection->sortValuesCallback($callback, false)->array());

        // keep keys
        $collection = new Collection($baseArray);
        $sorted = $baseArray;
        uasort($sorted, $callback);
        $this->assertSame($sorted, $collection->sortValuesCallback($callback, true)->array());
    }
}
