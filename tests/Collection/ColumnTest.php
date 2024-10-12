<?php

namespace Kusabi\Collection\Tests\Collection;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class ColumnTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::column()
     */
    public function testColumnIndex()
    {
        $collection = new Collection([
            'player_1' => [
                'name' => 'John',
                'hp' => 50,
                'exp' => 1000
            ],
            'player_2' => [
                'name' => 'Jane',
                'hp' => 70,
                'exp' => 1000
            ]
        ]);

        $columns = $collection->column('hp', 'name');
        $this->assertInstanceOf(Collection::class, $columns);
        $this->assertCount(2, $columns);
        $this->assertSame(['John', 'Jane'], $columns->keys()->array());
        $this->assertSame(['John' => 50, 'Jane' => 70], $columns->array());
    }

    /**
     * @covers \Kusabi\Collection\Collection::column()
     */
    public function testColumnNoIndex()
    {
        $collection = new Collection([
            'player_1' => [
                'name' => 'John',
                'hp' => 50,
                'exp' => 1000
            ],
            'player_2' => [
                'name' => 'Jane',
                'hp' => 70,
                'exp' => 1000
            ]
        ]);

        $columns = $collection->column('hp');
        $this->assertInstanceOf(Collection::class, $columns);
        $this->assertCount(2, $columns);
        $this->assertSame([50, 70], $columns->array());
    }
}
