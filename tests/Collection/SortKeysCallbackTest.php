<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class SortKeysCallbackTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::sortKeysCallback()
     */
    public function testSortKeysCallback()
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

        $collection = new Collection($baseArray);
        $sorted = $baseArray;
        uksort($sorted, $callback);
        $this->assertSame($sorted, $collection->sortKeysCallback($callback)->array());
    }
}
