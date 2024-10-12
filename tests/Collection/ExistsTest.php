<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class ExistsTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::exists()
     */
    public function testExists()
    {
        $collection = new Collection([
            'a' => 1,
            'b' => 2,
            'c' => [
                'a' => 1,
                'b' => null,
                'c' => 3,
            ],
        ]);
        $this->assertSame(true, $collection->exists('a'));
        $this->assertSame(false, $collection->exists('z'));
        $this->assertSame(false, $collection->exists('a.a'));
        $this->assertSame(true, $collection->exists('c.a'));
        $this->assertSame(true, $collection->exists('c.b'));
        $this->assertSame(false, $collection->exists('c.z'));
    }
}
