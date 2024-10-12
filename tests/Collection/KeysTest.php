<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class KeysTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::keys()
     */
    public function testKeys()
    {
        $collection = new Collection();
        $collection['test'] = 1;
        $collection[] = 1;
        $collection['sudo'] = 1;
        $keys = $collection->keys();
        $this->assertSame(['test', 0, 'sudo'], $keys->array());

        $collection = new Collection([
            'a' => 1,
            'b' => 2,
            'c' => [
                'a' => 1,
                'b' => null,
                'c' => 3,
            ],
        ]);
        $this->assertSame(['a', 'b', 'c'], $collection->keys()->array());
        $this->assertSame(['a', 'b', 'c.a', 'c.b', 'c.c'], $collection->keys(true)->array());
    }
}
