<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class MergeTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::merge()
     */
    public function testMerge()
    {
        $array_one = [
            'a' => true,
            'b' => false,
            'c' => 10,
            'd' => 100.54,
            'e' => 'hello',
            'f' => [
                'a' => true,
                'b' => false,
                'c' => 10,
                'd' => 100.54,
                'e' => 'hello',
                'f' => 'hello',
            ],
        ];

        $array_two = [
            'u' => true,
            'v' => false,
            'w' => 10,
            'x' => 100.54,
            'y' => 'hello',
            'z' => [
                'a' => true,
                'b' => false,
                'c' => 10,
                'd' => 100.54,
                'e' => 'hello',
                'f' => 'hello',
            ],
        ];

        $array_three = [
            'a' => true,
            'b' => false,
            'c' => 10,
            'd' => 100.54,
            'e' => 'hello',
            'f' => [
                'u' => true,
                'v' => false,
                'w' => 10,
                'x' => 100.54,
                'y' => 'hello',
                'z' => 'hello',
            ],
        ];

        // 1 then 2
        $this->assertSame(array_merge($array_one, $array_two), Collection::instance($array_one)->merge($array_two)->array());
        $this->assertSame(array_merge($array_one, $array_two), Collection::instance($array_one)->merge(new Collection($array_two))->array());

        // 1 then 2 then 3
        $this->assertSame(array_merge($array_one, $array_two, $array_three), Collection::instance($array_one)->merge($array_two, $array_three)->array());
        $this->assertSame(array_merge($array_one, $array_two, $array_three), Collection::instance($array_one)->merge(new Collection($array_two), new Collection($array_three))->array());

        // 1 then 3
        $this->assertSame(array_merge($array_one, $array_three), Collection::instance($array_one)->merge($array_three)->array());
        $this->assertSame(array_merge($array_one, $array_three), Collection::instance($array_one)->merge(new Collection($array_three))->array());

        // 1 then 3 then 2
        $this->assertSame(array_merge($array_one, $array_three, $array_two), Collection::instance($array_one)->merge($array_three, $array_two)->array());
        $this->assertSame(array_merge($array_one, $array_three, $array_two), Collection::instance($array_one)->merge(new Collection($array_three), new Collection($array_two))->array());

        // 2 then 3
        $this->assertSame(array_merge($array_two, $array_three), Collection::instance($array_two)->merge($array_three)->array());
        $this->assertSame(array_merge($array_two, $array_three), Collection::instance($array_two)->merge(new Collection($array_three))->array());

        // 2 then 3 then 1
        $this->assertSame(array_merge($array_two, $array_three, $array_one), Collection::instance($array_two)->merge($array_three, $array_one)->array());
        $this->assertSame(array_merge($array_two, $array_three, $array_one), Collection::instance($array_two)->merge(new Collection($array_three), new Collection($array_one))->array());

        // 2 then 1
        $this->assertSame(array_merge($array_two, $array_one), Collection::instance($array_two)->merge($array_one)->array());
        $this->assertSame(array_merge($array_two, $array_one), Collection::instance($array_two)->merge(new Collection($array_one))->array());

        // 2 then 1 then 3
        $this->assertSame(array_merge($array_two, $array_one, $array_three), Collection::instance($array_two)->merge($array_one, $array_three)->array());
        $this->assertSame(array_merge($array_two, $array_one, $array_three), Collection::instance($array_two)->merge(new Collection($array_one), new Collection($array_three))->array());

        // 3 then 1
        $this->assertSame(array_merge($array_three, $array_one), Collection::instance($array_three)->merge($array_one)->array());
        $this->assertSame(array_merge($array_three, $array_one), Collection::instance($array_three)->merge(new Collection($array_one))->array());

        // 3 then 1 then 2
        $this->assertSame(array_merge($array_three, $array_one, $array_two), Collection::instance($array_three)->merge($array_one, $array_two)->array());
        $this->assertSame(array_merge($array_three, $array_one, $array_two), Collection::instance($array_three)->merge(new Collection($array_one), new Collection($array_two))->array());

        // 3 then 2
        $this->assertSame(array_merge($array_three, $array_two), Collection::instance($array_three)->merge($array_two)->array());
        $this->assertSame(array_merge($array_three, $array_two), Collection::instance($array_three)->merge(new Collection($array_two))->array());

        // 3 then 2 then 1
        $this->assertSame(array_merge($array_three, $array_two, $array_one), Collection::instance($array_three)->merge($array_two, $array_one)->array());
        $this->assertSame(array_merge($array_three, $array_two, $array_one), Collection::instance($array_three)->merge(new Collection($array_two), new Collection($array_one))->array());
    }
}
