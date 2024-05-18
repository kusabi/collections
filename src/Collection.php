<?php

namespace Kusabi\Collection;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;

class Collection implements ArrayAccess, Countable, IteratorAggregate
{
    /**
     * The underlying data
     *
     * @var array
     */
    protected $data = [];

    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * Attempt to convert the input into an array
     *
     * @param $input
     *
     * @return array
     *
     * @see array_from()
     */
    public static function array($input): array
    {
        if ($input instanceof self) {
            return $input->getArray();
        }
        return array_from($input);
    }

    /**
     * Chainable constructor that attempts to be smart about the input parameter
     *
     * @param mixed $data
     *
     * @return static
     */
    public static function instance($data = []): self
    {
        return new static(static::array($data));
    }

    /**
     * Create a collection with a given range
     *
     * @param $start
     * @param $end
     * @param int|float $step
     *
     * @return static
     *
     * @see range()
     */
    public static function range($start, $end, $step = 1): self
    {
        return new static(range($start, $end, $step));
    }

    /**
     * Changes the case of all keys in an array
     *
     * @param int $case
     *
     * @return static
     *
     * @see array_change_key_case()
     */
    public function changeKeyCase(int $case = CASE_LOWER): self
    {
        $this->data = array_change_key_case($this->data, $case);
        return $this;
    }

    /**
     * Split the collection into chunks
     *
     * @param int $length
     * @param bool $preserve_keys
     *
     * @return static
     *
     * @see array_chunk()
     */
    public function chunk(int $length, bool $preserve_keys = true): self
    {
        return static::instance(array_chunk($this->data, $length, $preserve_keys))->map(function ($chunk) {
            return static::instance($chunk);
        });
    }

    /**
     * Return the values from a single column in the input array
     *
     * @param int|string $key
     * @param int|string|null $index
     *
     * @return static
     *
     * @see array_column()
     */
    public function column($key, $index = null): self
    {
        return new static(array_column($this->data, $key, $index));
    }

    /**
     * Create a new collection using this collection's values as keys, and other values as values
     *
     * @param iterable $other
     *
     * @return static
     *
     * @see array_combine()
     */
    public function combine(iterable $other): self
    {
        return new static(array_combine($this->data, static::array($other)));
    }

    /**
     * {@inheritDoc}
     *
     * @see Countable::count
     */
    public function count(): int
    {
        return count($this->data);
    }

    /**
     * Count the number of times each value appears in the array
     *
     * @return static
     *
     * @see array_count_values()
     */
    public function countValues(): self
    {
        return new static(array_count_values($this->data));
    }

    /**
     * Flatten the nested collection into a new collection.
     *
     * By default, it will keep the keys but use a dot notation to indicate depth.
     *
     * @param bool $keys
     *
     * @return static
     */
    public function deflate(bool $keys = true): self
    {
        return new Collection(array_deflate($this->data, $keys));
    }

    /**
     * Compute the difference between other collections or arrays
     *
     * Collection|array ...$others
     *
     * @return static
     *
     * @see array_diff()
     */
    public function diff(...$others): self
    {
        foreach ($others as &$other) {
            if ($other instanceof Collection) {
                $other = $other->getArray();
            }
        }
        unset($other);
        $other = array_shift($others);
        return new static(array_diff($this->data, $other, ...$others));
    }

    /**
     * Checks if the given key or index exists in the collection
     *
     * Allows for dot notation to query nested collections
     *
     * @param string|int $key
     *
     * @return bool
     *
     * @see array_key_exists()
     * @see array_exists()
     */
    public function exists($key): bool
    {
        return array_exists($this->data, $key);
    }

    /**
     * Filters elements of the collection using a callback function
     *
     * @param callable|null $callback
     *
     * @return static
     *
     * @see array_filter()
     */
    public function filter(callable $callback = null, int $mode = 0): self
    {
        if ($callback === null) {
            return new static(array_filter($this->data));
        }
        return new static(array_filter($this->data, $callback, $mode));
    }

    /**
     * Get the first item in the collection.
     *
     * If a callback is provided then get the first item in the collection that passes the callback.
     *
     * If no item is ever found, either because there are no items or the callback never returns true, then return default.
     *
     * @param callable|null $callback
     * @param mixed $default
     *
     * @return mixed
     */
    public function first(callable $callback = null, $default = null)
    {
        foreach ($this->data as $key => $value) {
            if ($callback === null || $callback($value, $key) === true) {
                return $value;
            }
        }

        return $default;
    }

    /**
     * Exchanges all keys with their associated values in the collection
     *
     * @return static
     */
    public function flip(): self
    {
        return new static(array_flip($this->data));
    }

    /**
     * Get the underlying array
     *
     * @return array
     */
    public function getArray(): array
    {
        return $this->data;
    }

    /**
     * {@inheritDoc}
     *
     * @see IteratorAggregate::getIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->data);
    }

    /**
     * Join all the elements into a string with the glue string
     *
     * If a lastGlue is used then the last item will use a different glue string
     *
     * @param string $glue
     * @param string|null $lastGlue
     *
     * @return string
     */
    public function implode(string $glue = '', string $lastGlue = null): string
    {
        return array_join($this->data, $glue, $lastGlue);
    }

    /**
     * Expands a flattened collection into a new nested collection.
     *
     * This will not work on flattened arrays where the keys were not kept.
     *
     * @return static
     */
    public function inflate(): self
    {
        return new Collection(array_inflate($this->data));
    }

    /**
     * Determine if the collection is empty.
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->data);
    }

    /**
     * Checks whether the collection is a list
     *
     * A collection is considered a list if its keys consist of consecutive numbers from 0 to count()
     *
     * @return bool
     *
     * @see array_is_list()
     */
    public function isList(): bool
    {
        return array_is_list($this->data);
    }

    /**
     * Return anew collection with the keys from this collection
     *
     * @return static
     */
    public function keys(bool $recursive = false): self
    {
        if ($recursive) {
            return $this->deflate()->keys();
        }
        return new static(array_keys($this->data));
    }

    /**
     * Get the last item in the collection.
     *
     * If a callback is provided then get the last item in the collection that passes the callback.
     *
     * If no item is ever found, either because there are no items or the callback never returns true, then return default.
     *
     * @param callable|null $callback
     * @param mixed $default
     *
     * @return mixed
     *
     * @see Collection::first()
     */
    public function last(callable $callback = null, $default = null)
    {
        return $this->reverse()->first($callback, $default);
    }

    /**
     * Map the results on the collection into a new collection
     *
     * Setting $nested to true will deflate the collection first, then re-inflate, allowing you to map all nested items
     *
     * @param callable $callback
     * @param bool $nested
     *
     * @return static
     *
     * @see Collection::deflate()
     * @see Collection::inflate()
     */
    public function map(callable $callback, bool $nested = false): self
    {
        $data = $this->data;
        if ($nested) {
            $data = array_deflate($data);
        }
        $keys = array_keys($data);
        $values = array_map($callback, $data, $keys);
        $results = array_combine($keys, $values);
        if ($nested) {
            $results = array_inflate($results);
        }
        return new Collection($results);
    }

    /**
     * {@inheritDoc}
     *
     * @see ArrayAccess::offsetExists
     */
    public function offsetExists($offset): bool
    {
        return array_exists($this->data, $offset);
    }

    /**
     * {@inheritDoc}
     *
     * @see ArrayAccess::offsetGet
     */
    public function offsetGet($offset)
    {
        return array_get($this->data, $offset);
    }

    /**
     * {@inheritDoc}
     *
     * @see ArrayAccess::offsetSet
     */
    public function offsetSet($offset, $value)
    {
        if ($offset === null) {
            $this->data[] = $value;
        } else {
            array_set($this->data, $offset, $value);
        }
    }

    /**
     * {@inheritDoc}
     *
     * @see ArrayAccess::offsetUnset
     */
    public function offsetUnset($offset)
    {
        array_unset($this->data, $offset);
    }

    /**
     * Reverse the items in to a new collection
     *
     * @return static
     */
    public function reverse(): self
    {
        return new static(array_reverse($this->data, true));
    }

    /**
     * Returns the sum of values as an integer or float; 0 if the array is empty.
     *
     * @return int|float
     *
     * @see array_sum()
     */
    public function sum()
    {
        return array_sum($this->data);
    }
}
