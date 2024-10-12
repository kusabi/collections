<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class ChunkTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::chunk()
     */
    public function testChunkKeepKeys()
    {
        $collection = Collection::range(0, 99);

        $chunks = $collection->chunk(20);
        $this->assertInstanceOf(Collection::class, $chunks);
        $this->assertCount(5, $chunks);
        for ($i = 0; $i < 5; $i++) {
            $this->assertInstanceOf(Collection::class, $chunks[$i]);
            $this->assertCount(20, $chunks[$i]);
            for ($j = 0; $j < 20; $j++) {
                $b = $i * 20;
                $key = $b + $j;
                $value = $b + $j;
                $this->assertSame($value, $chunks[$i][$key]);
            }
        }
    }

    /**
     * @covers \Kusabi\Collection\Collection::chunk()
     */
    public function testChunkLoseKeys()
    {
        $collection = Collection::range(0, 99);

        $chunks = $collection->chunk(20, false);
        $this->assertInstanceOf(Collection::class, $chunks);
        $this->assertCount(5, $chunks);
        for ($i = 0; $i < 5; $i++) {
            $this->assertInstanceOf(Collection::class, $chunks[$i]);
            $this->assertCount(20, $chunks[$i]);
            for ($j = 0; $j < 20; $j++) {
                $b = $i * 20;
                $key = $j;
                $value = $b + $j;
                $this->assertSame($value, $chunks[$i][$key]);
            }
        }
    }
}
