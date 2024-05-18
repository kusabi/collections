<?php

namespace Kusabi\Collection\Tests;

use Kusabi\Collection\Collection;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    /**
     * @covers \Kusabi\Collection\Collection::array()
     */
    public function testArray()
    {
        $array = [
            'a' => [
                'b' => [
                    'a' => 10,
                    'b' => 11,
                    'c' => 12,
                ]
            ]
        ];
        $collection = new Collection($array);
        $this->assertSame($array, $collection->array());
    }

    /**
     * @covers \Kusabi\Collection\Collection::castArray()
     */
    public function testCastArray()
    {
        $this->assertSame([1, 2, 3], Collection::castArray([1, 2, 3]));

        $this->assertSame([1], Collection::castArray(1));

        $this->assertSame(['h', 'e', 'l', 'l', 'o'], Collection::castArray('hello'));

        $this->assertSame([1, 2, 3, 4], Collection::castArray(new Collection([1, 2, 3, 4])));
    }

    /**
     * @covers \Kusabi\Collection\Collection::changeKeyCase()
     */
    public function testChangeCase()
    {
        $collection = new Collection(['FirSt' => 1, 'SecOnd' => 4]);
        $this->assertSame(['first' => 1, 'second' => 4], $collection->changeKeyCase(CASE_LOWER)->array());
        $this->assertSame(['FIRST' => 1, 'SECOND' => 4], $collection->changeKeyCase(CASE_UPPER)->array());
    }

    /**
     * @covers \Kusabi\Collection\Collection::chunk()
     */
    public function testChunk()
    {
        $collection = Collection::range(0, 99);

        // Chunked - Keep keys
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

        // Chunked - Do not keep keys
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

    /**
     * @covers \Kusabi\Collection\Collection::column()
     */
    public function testColumn()
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
        $this->assertSame([50, 70], $collection->column('hp')->array());
        $this->assertSame(['John' => 50, 'Jane' => 70], $collection->column('hp', 'name')->array());
    }

    /**
     * @covers \Kusabi\Collection\Collection::combine()
     */
    public function testCombine()
    {
        // Combine with array
        $collection = new Collection(['x', 'y', 'z']);
        $array = ['a', 'b', 'c'];
        $combined = $collection->combine($array);
        $this->assertSame(['x' => 'a', 'y' => 'b', 'z' => 'c'], $combined->array());
        $this->assertSame(['x', 'y', 'z'], $collection->array());
        $this->assertSame(['a', 'b', 'c'], $array);

        // Combine with collection
        $this->assertSame(
            ['x' => 'a', 'y' => 'b', 'z' => 'c'],
            Collection::instance(['x', 'y', 'z'])->combine(Collection::instance(['a', 'b', 'c']))->array()
        );
    }

    /**
     * @covers \Kusabi\Collection\Collection::__construct()
     */
    public function testConstructorWithNoParameter()
    {
        $collection = new Collection();
        $this->assertEmpty($collection);
        $this->assertCount(0, $collection);
    }

    /**
     * @covers \Kusabi\Collection\Collection::__construct()
     */
    public function testConstructorWithParameter()
    {
        $collection = new Collection([1, 2, 3]);
        $this->assertNotEmpty($collection);
        $this->assertCount(3, $collection);
        $this->assertSame(1, $collection[0]);
        $this->assertSame(2, $collection[1]);
        $this->assertSame(3, $collection[2]);
    }

    /**
     * @covers \Kusabi\Collection\Collection::contains()
     */
    public function testContains()
    {
        $collection = new Collection([4, 5, 6]);
        $this->assertSame(false, $collection->contains(1));
        $this->assertSame(false, $collection->contains(2));
        $this->assertSame(false, $collection->contains(3));
        $this->assertSame(true, $collection->contains(4));
        $this->assertSame(true, $collection->contains(5));
        $this->assertSame(true, $collection->contains(6));
    }

    /**
     * @covers \Kusabi\Collection\Collection::count()
     */
    public function testCount()
    {
        $collection = new Collection();
        $this->assertCount(0, $collection);
        $collection[] = 1;
        $collection[] = 2;
        $collection[] = 3;
        $this->assertCount(3, $collection);
    }

    /**
     * @covers \Kusabi\Collection\Collection::countValues()
     */
    public function testCountValues()
    {
        $collection = new Collection([1, 2, 3, 1, 2, 4, 'a', 'a', 1]);

        $appearances = $collection->countValues(); // [1 => 3, 2 => 2, 3 => 1, 4 => 1, 'a' => 2]

        $this->assertInstanceOf(Collection::class, $appearances);

        $this->assertSame([1 => 3, 2 => 2, 3 => 1, 4 => 1, 'a' => 2], $appearances->array());
    }

    /**
     * @covers \Kusabi\Collection\Collection::deflate()
     */
    public function testDeflateKeepKeys()
    {
        $collection = new Collection();
        $collection['a.b.c'] = 1;
        $collection['a.c.a'] = 2;
        $this->assertSame([
            'a' => [
                'b' => [
                    'c' => 1
                ],
                'c' => [
                    'a' => 2
                ]
            ]
        ], $collection->array());

        $deflated = $collection->deflate();
        $this->assertSame([
            'a.b.c' => 1,
            'a.c.a' => 2,
        ], $deflated->array());

        $this->assertSame([
            'a' => [
                'b' => [
                    'c' => 1
                ],
                'c' => [
                    'a' => 2
                ]
            ]
        ], $collection->array());

        $this->assertNotSame($collection, $deflated);
    }

    /**
     * @covers \Kusabi\Collection\Collection::deflate()
     */
    public function testDeflateNoKeepKeys()
    {
        $collection = new Collection();
        $collection['a.b.c'] = 1;
        $collection['a.c.a'] = 2;
        $this->assertSame([
            'a' => [
                'b' => [
                    'c' => 1
                ],
                'c' => [
                    'a' => 2
                ]
            ]
        ], $collection->array());

        $deflated = $collection->deflate(false);
        $this->assertSame([
            0 => 1,
            1 => 2,
        ], $deflated->array());

        $this->assertSame([
            'a' => [
                'b' => [
                    'c' => 1
                ],
                'c' => [
                    'a' => 2
                ]
            ]
        ], $collection->array());

        $this->assertNotSame($collection, $deflated);
    }

    /**
     * @covers \Kusabi\Collection\Collection::diff()
     */
    public function testDiff()
    {
        $a = [1, 2, 3, 5, 6, 7, 8, 9, 10];
        $b = [6, 7, 8, 9, 10, 11, 12, 13];
        $c = [1, 2, 3, 12, 13];
        $d = [1, 2, 3];

        $this->assertSame(array_diff($a, $b), Collection::instance($a)->diff($b)->array());
        $this->assertSame(array_diff($a, $b, $c, $d), Collection::instance($a)->diff($b, $c, $d)->array());
        $this->assertSame(array_diff($a, $b, $c, $d), Collection::instance($a)->diff($b, Collection::instance($c), Collection::instance($d))->array());
        $this->assertSame(array_diff($a, $b, $c, $d), Collection::instance($a)->diff(Collection::instance($b), Collection::instance($c), Collection::instance($d))->array());
        $this->assertSame(array_diff($a, $b), Collection::instance($a)->diff(Collection::instance($b))->array());
    }

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

    /**
     * @covers \Kusabi\Collection\Collection::values()
     */
    public function testExtract()
    {
        $collection = new Collection(['a' => 1, 'b' => 2]);
        extract($collection->array());
        $this->assertSame(1, $a);
        $this->assertSame(2, $b);
    }

    /**
     * @covers \Kusabi\Collection\Collection::filter()
     */
    public function testFilter()
    {
        // No callback removes empty values
        $this->assertSame([2 => 1, 4 => 2, 5 => 3], Collection::instance([null, '', 1, null, 2, 3, null])->filter()->array());

        // Callback
        $collection = Collection::range(1, 100)->filter(function ($value) {
            return $value < 10;
        });
        $this->assertSame([1, 2, 3, 4, 5, 6, 7, 8, 9], $collection->array());

        // String callback
        $collection = new Collection([1, 2, 'hello', null]);
        $this->assertSame([2 => 'hello'], $collection->filter('is_string')->array());

        // Filter based on keys
        $collection = new Collection([9, 8, 7, 6, 5, 4, 3, 2, 1]);
        $this->assertSame([6 => 3, 7 => 2, 8 => 1], $collection->filter(function ($value, $key) {
            return $key > 5;
        }, ARRAY_FILTER_USE_BOTH)->array());
    }

    /**
     * @covers \Kusabi\Collection\Collection::first()
     */
    public function testFirst()
    {
        // No callback, no default, no items
        $collection = new Collection();
        $this->assertSame(null, $collection->first());

        // No callback, no default, 1 item
        $collection = new Collection([10]);
        $this->assertSame(10, $collection->first());

        // No callback, no default, x items
        $collection = new Collection([10, 9, 8]);
        $this->assertSame(10, $collection->first());

        // No callback, yes default, no items
        $collection = new Collection();
        $this->assertSame('test', $collection->first(null, 'test'));

        // No callback, yes default, 1 item
        $collection = new Collection([10]);
        $this->assertSame(10, $collection->first(null, 'test'));

        // No callback, yes default, x items
        $collection = new Collection([10, 9, 8]);
        $this->assertSame(10, $collection->first(null, 'test'));

        // Callback that fails to match anything, no default
        $collection = new Collection([1, 2, 3, 4]);
        $this->assertSame(null, $collection->first(function ($value) {
            return $value > 10;
        }));

        // Callback that fails to match anything, with default
        $collection = new Collection([1, 2, 3, 4]);
        $this->assertSame('test', $collection->first(function ($value) {
            return $value > 10;
        }, 'test'));

        // Callback that matches on value
        $collection = new Collection([1, 2, 3, 4]);
        $this->assertSame(3, $collection->first(function ($value) {
            return $value > 2;
        }));

        // Callback that matches on key
        $collection = new Collection([9 => 1, 8 => 2,  7 => 3, 6 => 4]);
        $this->assertSame(2, $collection->first(function ($value, $key) {
            return $key < 9;
        }));
    }

    public function testFirstKey()
    {
        $collection = new Collection(['a' => 1, 'b' => 2, 'c' => 3]);
        $this->assertSame('a', $collection->keys()->first());
    }

    /**
     * @covers \Kusabi\Collection\Collection::flip()
     */
    public function testFlip()
    {
        $collection = new Collection(['a', 'b', 'c']);
        $this->assertSame(['a' => 0, 'b' => 1, 'c' => 2], $collection->flip()->array());

        $collection = new Collection(['a', 'b', 'c', 'a']);
        $this->assertSame(['a' => 3, 'b' => 1, 'c' => 2], $collection->flip()->array());
        $this->assertSame([3 => 'a', 1 => 'b', 2 => 'c'], $collection->flip()->flip()->array());
    }

    /**
     * @covers \Kusabi\Collection\Collection::offsetGet()
     */
    public function testGetNestedKey()
    {
        $collection = new Collection([
            'a' => [
                'b' => [
                    'a' => 10,
                    'b' => 11,
                    'c' => 12,
                ]
            ]
        ]);
        $this->assertSame(10, $collection['a.b.a']);
        $this->assertSame(11, $collection['a.b.b']);
        $this->assertSame(12, $collection['a.b.c']);
    }

    /**
     * @covers \Kusabi\Collection\Collection::implode()
     */
    public function testImplode()
    {
        $this->assertSame('', Collection::instance()->implode());
        $this->assertSame('', Collection::instance()->implode(', '));
        $this->assertSame('', Collection::instance()->implode(', ', ' and '));

        $this->assertSame('a', Collection::instance(['a'])->implode());
        $this->assertSame('a', Collection::instance(['a'])->implode(', '));
        $this->assertSame('a', Collection::instance(['a'])->implode(', ', ' and '));

        $this->assertSame('ab', Collection::instance(['a', 'b'])->implode());
        $this->assertSame('a, b', Collection::instance(['a', 'b'])->implode(', '));
        $this->assertSame('a and b', Collection::instance(['a', 'b'])->implode(', ', ' and '));

        $this->assertSame('abc', Collection::instance(['a', 'b', 'c'])->implode());
        $this->assertSame('a, b, c', Collection::instance(['a', 'b', 'c'])->implode(', '));
        $this->assertSame('a, b and c', Collection::instance(['a', 'b', 'c'])->implode(', ', ' and '));

        $this->assertSame('abcd', Collection::instance(['a', 'b', 'c', 'd'])->implode());
        $this->assertSame('a, b, c, d', Collection::instance(['a', 'b', 'c', 'd'])->implode(', '));
        $this->assertSame('a, b, c and d', Collection::instance(['a', 'b', 'c', 'd'])->implode(', ', ' and '));
    }

    /**
     * @covers \Kusabi\Collection\Collection::inflate()
     */
    public function testInflate()
    {
        $collection = new Collection(['a.b.c' => 1]);
        $inflated = $collection->inflate();
        $this->assertSame([
            'a' => [
                'b' => [
                    'c' => 1,
                ]
            ]
        ], $inflated->array());
        $this->assertSame([
            'a.b.c' => 1
        ], $collection->array());
        $this->assertNotSame($collection, $inflated);
    }

    /**
     * @covers \Kusabi\Collection\Collection::instance()
     */
    public function testInstanceWithNoParameter()
    {
        $collection = Collection::instance();
        $this->assertEmpty($collection);
        $this->assertCount(0, $collection);
    }

    /**
     * @covers \Kusabi\Collection\Collection::instance()
     */
    public function testInstanceWithParameter()
    {
        $collection = Collection::instance([1, 2, 3]);
        $this->assertNotEmpty($collection);
        $this->assertCount(3, $collection);
        $this->assertSame(1, $collection[0]);
        $this->assertSame(2, $collection[1]);
        $this->assertSame(3, $collection[2]);

        $this->assertSame(['h', 'e', 'l', 'l', 'o'], Collection::instance('hello')->array());
        $this->assertSame([1], Collection::instance(1)->array());

        $this->assertSame('olleh', Collection::instance('hello')->reverse()->implode());
    }

    /**
     * @covers \Kusabi\Collection\Collection::isEmpty()
     */
    public function testIsEmpty()
    {
        $collection = new Collection();
        $this->assertTrue($collection->isEmpty());
        $collection[] = 1;
        $this->assertFalse($collection->isEmpty());
        unset($collection[0]);
        $this->assertTrue($collection->isEmpty());
    }

    /**
     * @covers \Kusabi\Collection\Collection::isList()
     */
    public function testIsList()
    {
        $this->assertSame(true, Collection::range(0, 100)->isList());
        $this->assertSame(false, Collection::instance(['a' => 1])->isList());
    }

    /**
     * @covers \Kusabi\Collection\Collection::getIterator()
     */
    public function testIterable()
    {
        $array = ['a' => 1, 'b' => 2, 'c' => 3];
        $collection = new Collection($array);

        foreach ($collection as $key => $value) {
            $this->assertSame(current($array), $value);
            $this->assertSame(key($array), $key);
            next($array);
        }

        $this->assertSame($array, iterator_to_array($collection));
    }

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

    /**
     * @covers \Kusabi\Collection\Collection::last()
     */
    public function testLast()
    {
        // No callback, no default, no items
        $collection = new Collection();
        $this->assertSame(null, $collection->last());

        // No callback, no default, 1 item
        $collection = new Collection([10]);
        $this->assertSame(10, $collection->last());

        // No callback, no default, x items
        $collection = new Collection([10, 9, 8]);
        $this->assertSame(8, $collection->last());

        // No callback, yes default, no items
        $collection = new Collection();
        $this->assertSame('test', $collection->last(null, 'test'));

        // No callback, yes default, 1 item
        $collection = new Collection([10]);
        $this->assertSame(10, $collection->last(null, 'test'));

        // No callback, yes default, x items
        $collection = new Collection([10, 9, 8]);
        $this->assertSame(8, $collection->last(null, 'test'));

        // Callback that fails to match anything, no default
        $collection = new Collection([1, 2, 3, 4]);
        $this->assertSame(null, $collection->last(function ($value) {
            return $value > 10;
        }));

        // Callback that fails to match anything, with default
        $collection = new Collection([1, 2, 3, 4]);
        $this->assertSame('test', $collection->last(function ($value) {
            return $value > 10;
        }, 'test'));

        // Callback that matches on value
        $collection = new Collection([1, 2, 3, 4]);
        $this->assertSame(3, $collection->last(function ($value) {
            return $value < 4;
        }));

        // Callback that matches on key
        $collection = new Collection([9 => 1, 8 => 2,  7 => 3, 6 => 4]);
        $this->assertSame(3, $collection->last(function ($value, $key) {
            return $key > 6;
        }));
    }

    public function testLastKey()
    {
        $collection = new Collection(['a' => 1, 'b' => 2, 'c' => 3]);
        $this->assertSame('c', $collection->keys()->last());
    }

    /**
     * @covers \Kusabi\Collection\Collection::map()
     */
    public function testMapNestedWithKey()
    {
        $collection = new Collection();
        $collection['a'] = 1;
        $collection['b.a'] = 2;
        $collection['b.b'] = 3;
        $collection['c.z'] = 4;

        $mapped = $collection->map(function ($value, $key) {
            return $key.'-'.$value;
        }, true);

        $this->assertSame('a-1', $mapped['a']);
        $this->assertSame('b.a-2', $mapped['b.a']);
        $this->assertSame('b.b-3', $mapped['b.b']);
        $this->assertSame('c.z-4', $mapped['c.z']);

        $this->assertSame([
            'a' => 'a-1',
            'b' => [
                'a' => 'b.a-2',
                'b' => 'b.b-3',
            ],
            'c' => [
                'z' => 'c.z-4',
            ],
        ], $mapped->array());
    }

    /**
     * @covers \Kusabi\Collection\Collection::map()
     */
    public function testMapNestedWithoutKey()
    {
        $collection = new Collection();
        $collection['a'] = 1;
        $collection['b.a'] = 2;
        $collection['b.b'] = 3;
        $collection['c.z'] = 4;

        $mapped = $collection->map(function ($value) {
            return $value * 10;
        }, true);

        $this->assertSame(10, $mapped['a']);
        $this->assertSame(20, $mapped['b.a']);
        $this->assertSame(30, $mapped['b.b']);
        $this->assertSame(40, $mapped['c.z']);

        $this->assertSame([
            'a' => 10,
            'b' => [
                'a' => 20,
                'b' => 30,
            ],
            'c' => [
                'z' => 40,
            ],
        ], $mapped->array());
    }

    /**
     * @covers \Kusabi\Collection\Collection::map()
     */
    public function testMapWithKey()
    {
        $collection = new Collection([
            'a' => 1,
            'b' => 2,
            'c' => 3,
        ]);

        $mapped = $collection->map(function ($value, $key) {
            return $key.'-'.$value;
        });

        $this->assertSame('a-1', $mapped['a']);
        $this->assertSame('b-2', $mapped['b']);
        $this->assertSame('c-3', $mapped['c']);

        $this->assertSame([
            'a' => 'a-1',
            'b' => 'b-2',
            'c' => 'c-3',
        ], $mapped->array());
    }

    /**
     * @covers \Kusabi\Collection\Collection::map()
     */
    public function testMapWithoutKey()
    {
        $collection = new Collection([
            'a' => 1,
            'b' => 2,
            'c' => 3,
        ]);

        $mapped = $collection->map(function ($value) {
            return $value * 10;
        });

        $this->assertSame(10, $mapped['a']);
        $this->assertSame(20, $mapped['b']);
        $this->assertSame(30, $mapped['c']);

        $this->assertSame([
            'a' => 10,
            'b' => 20,
            'c' => 30,
        ], $mapped->array());
    }

    /**
     * @covers \Kusabi\Collection\Collection::offsetExists()
     */
    public function testOffsetExists()
    {
        $collection = new Collection(['a' => 'b']);
        $this->assertTrue(isset($collection['a']));
        $this->assertFalse(isset($collection['b']));
        unset($collection['a']);
        $this->assertFalse(isset($collection['a']));
    }

    /**
     * @covers \Kusabi\Collection\Collection::offsetExists()
     */
    public function testOffsetExistsNestKey()
    {
        $collection = new Collection([
            'a' => [
                'b' => [
                    'a' => 10,
                    'b' => 11,
                    'c' => 12,
                ]
            ]
        ]);
        $this->assertTrue(isset($collection['a.b.a']));
        $this->assertTrue(isset($collection['a.b.b']));
        $this->assertTrue(isset($collection['a.b.c']));
        $this->assertFalse(isset($collection['a.b.d']));
        $this->assertFalse(isset($collection['a.a']));
        unset($collection['a.b.c']);
        $this->assertFalse(isset($collection['a.b.c']));
    }

    /**
     * @covers \Kusabi\Collection\Collection::offsetGet()
     */
    public function testOffsetGet()
    {
        $collection = new Collection(['a' => 'b']);
        $this->assertSame('b', $collection['a']);
    }

    /**
     * @covers \Kusabi\Collection\Collection::offsetSet()
     *
     */
    public function testOffsetSet()
    {
        $collection = new Collection();
        $this->assertCount(0, $collection);
        $collection[] = 1;
        $collection[] = 2;
        $collection[] = 3;
        $collection['test'] = 4;
        $collection[2] = 99;
        $this->assertCount(4, $collection);
        $this->assertSame(1, $collection[0]);
        $this->assertSame(2, $collection[1]);
        $this->assertSame(99, $collection[2]);
        $this->assertSame(4, $collection['test']);
    }

    /**
     * @covers \Kusabi\Collection\Collection::pop()
     */
    public function testPop()
    {
        $collection = new Collection([1, 2, 3]);
        $popped = $collection->pop();
        $this->assertSame(3, $popped);
        $this->assertSame([1, 2], $collection->array());

        $collection = new Collection();
        $popped = $collection->pop();
        $this->assertSame(null, $popped);
        $this->assertSame([], $collection->array());
    }

    /**
     * @covers \Kusabi\Collection\Collection::push()
     */
    public function testPush()
    {
        $collection = new Collection([1, 2, 3]);
        $collection->push(4);
        $this->assertSame([1, 2, 3, 4], $collection->array());

        $collection->push(5, 6, 7, 8);
        $this->assertSame([1, 2, 3, 4, 5, 6, 7, 8], $collection->array());
    }

    /**
     * @covers \Kusabi\Collection\Collection::range()
     */
    public function testRange()
    {
        $this->assertSame(range(1, 100), Collection::range(1, 100)->array());
        $this->assertSame(range(1, 100, 20), Collection::range(1, 100, 20)->array());
        $this->assertSame(range('a', 'z'), Collection::range('a', 'z')->array());
        $this->assertSame([0, 2, 4, 6, 8, 10], Collection::range(0, 10, 2)->array());
    }

    /**
     * @covers \Kusabi\Collection\Collection::reduce()
     */
    public function testReduce()
    {
        $this->assertSame(3628800, Collection::range(1, 10)->reduce(function ($carry, $value) {
            return $carry * $value;
        }, 1));
    }

    /**
     * @covers \Kusabi\Collection\Collection::reverse()
     */
    public function testReverse()
    {
        $collection = new Collection(['a' => 1, 1 => 2, 'c' => 'd']);
        $reversed = $collection->reverse();
        $this->assertSame(['c' => 'd', 1 => 2, 'a' => 1], $reversed->array());
        $this->assertSame(['a' => 1, 1 => 2, 'c' => 'd'], $collection->array());
        $this->assertNotSame($collection, $reversed);
    }

    /**
     * @covers \Kusabi\Collection\Collection::offsetSet()
     */
    public function testSetNestedKey()
    {
        $collection = new Collection();
        $collection['a.b.a'] = 10;
        $collection['a.b.b'] = 10;
        $collection['a.b.c'] = 10;
        $this->assertSame([
            'a' => [
                'b' => [
                    'a' => 10,
                    'b' => 10,
                    'c' => 10,
                ]
            ]
        ], iterator_to_array($collection));
    }

    /**
     * @covers \Kusabi\Collection\Collection::shift()
     */
    public function testShift()
    {
        $collection = new Collection([1, 2, 3]);
        $shifted = $collection->shift();
        $this->assertSame(1, $shifted);
        $this->assertSame([2, 3], $collection->array());

        $collection = new Collection();
        $popped = $collection->shift();
        $this->assertSame(null, $popped);
        $this->assertSame([], $collection->array());
    }

    /**
     * @covers \Kusabi\Collection\Collection::sum()
     */
    public function testSum()
    {
        $this->assertSame(6, Collection::instance([1, 2, 3])->sum());
        $this->assertSame(5050, Collection::range(1, 100)->sum());
        $this->assertSame(3, Collection::instance([1, 2, 'a'])->sum());
    }

    /**
     * @covers \Kusabi\Collection\Collection::offsetUnset()
     */
    public function testUnset()
    {
        $collection = new Collection(['a' => 'b']);
        $this->assertTrue(isset($collection['a']));
        $this->assertFalse(isset($collection['b']));
        unset($collection['a']);
        $this->assertFalse(isset($collection['a']));
    }

    /**
     * @covers \Kusabi\Collection\Collection::unshift()
     */
    public function testUnshift()
    {
        $collection = new Collection([1, 2, 3]);
        $collection->unshift(4);
        $this->assertSame([4, 1, 2, 3], $collection->array());

        $collection->unshift(5, 6, 7, 8);
        $this->assertSame([5, 6, 7, 8, 4, 1, 2, 3], $collection->array());
    }

    /**
     * @covers \Kusabi\Collection\Collection::values()
     */
    public function testValues()
    {
        $collection = new Collection(['a' => 1, 'b' => 2, 'c' => 3]);
        $this->assertSame([1, 2, 3], $collection->values()->array());
    }
}
