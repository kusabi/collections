<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class ChangeCaseTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::changeKeyCase()
     */
    public function testChangeKeyCaseDefaultsToLower()
    {
        $collection = new Collection(['FirSt' => 1, 'SecOnd' => 4]);
        $this->assertSame(['first' => 1, 'second' => 4], $collection->changeKeyCase()->array());
    }

    /**
     * @covers \Kusabi\Collection\Collection::changeKeyCase()
     */
    public function testChangeKeyCaseLower()
    {
        $collection = new Collection(['FirSt' => 1, 'SecOnd' => 4]);
        $this->assertSame(['first' => 1, 'second' => 4], $collection->changeKeyCase(CASE_LOWER)->array());
    }

    /**
     * @covers \Kusabi\Collection\Collection::changeKeyCase()
     */
    public function testChangeKeyCaseUpper()
    {
        $collection = new Collection(['FirSt' => 1, 'SecOnd' => 4]);
        $this->assertSame(['FIRST' => 1, 'SECOND' => 4], $collection->changeKeyCase(CASE_UPPER)->array());
    }
}
