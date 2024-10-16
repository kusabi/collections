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
    public static function castArray($input): array
    {
        if ($input instanceof self) {
            return $input->array();
        }
        return array_from($input);
    }

    /**
     * Create a new collection filled to a certain size with a value
     *
     * @param int $start_index
     * @param int $count
     * @param $value
     *
     * @return static
     *
     * @see array_fill()
     */
    public static function fill(int $start_index, int $count, $value): self
    {
        return new static(array_fill($start_index, $count, $value));
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
        return new static(static::castArray($data));
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
     * Get the underlying array
     *
     * @return array
     */
    public function array(): array
    {
        return $this->data;
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
        return new static(array_combine($this->data, static::castArray($other)));
    }

    /**
     * Checks if a value exists in the collection
     *
     * @param mixed $needle
     * @param bool $strict
     *
     * @return bool
     *
     * @see in_array()
     */
    public function contains($needle, bool $strict = false): bool
    {
        return in_array($needle, $this->data, $strict);
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
     * Computes the difference between other collections or arrays using keys for comparison
     *
     * @param mixed ...$others
     *
     * @return static
     *
     * @see array_diff_key()
     */
    public function diffKeys(...$others): self
    {
        foreach ($others as $key => $other) {
            $others[$key] = static::castArray($other);
        }
        $other = array_shift($others);
        return new static(array_diff_key($this->data, $other, ...$others));
    }

    /**
     * Computes the difference between other collections or arrays using keys for comparison
     *
     * @param callable $key_compare_func
     * @param mixed ...$others
     *
     * @return static
     *
     * @see array_diff_key()
     */
    public function diffKeysCallback(callable $key_compare_func, ...$others): self
    {
        foreach ($others as $key => $other) {
            $others[$key] = static::castArray($other);
        }
        $first = array_shift($others);
        $others[] = $key_compare_func;
        return new static(array_diff_ukey($this->data, $first, ...$others));
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
    public function diffValues(...$others): self
    {
        foreach ($others as $key => $other) {
            $others[$key] = static::castArray($other);
        }
        $other = array_shift($others);
        return new static(array_diff($this->data, $other, ...$others));
    }

    /**
     * Computes the difference between other collections or arrays with additional index check
     * Returns a collection of entries in this collection, where the key and value combination are not in others
     *
     * @param mixed ...$others
     *
     * @return static
     *
     * @see array_diff_assoc()
     */
    public function diffValuesAndKeys(...$others): self
    {
        foreach ($others as $key => $other) {
            $others[$key] = static::castArray($other);
        }
        $other = array_shift($others);
        return new static(array_diff_assoc($this->data, $other, ...$others));
    }

    /**
     * Computes the difference between other collections or arrays with additional index check
     * Returns a collection of entries in this collection, where the key and value combination are not in others
     * Uses a callback to compare the keys
     *
     * @param callable $key_compare_func
     * @param mixed ...$others
     *
     * @return static
     *
     * @see array_diff_assoc()
     */
    public function diffValuesAndKeysCallback(callable $key_compare_func, ...$others): self
    {
        foreach ($others as $key => $other) {
            $others[$key] = static::castArray($other);
        }
        $first = array_shift($others);
        $others[] = $key_compare_func;
        return new static(array_diff_uassoc($this->data, $first, ...$others));
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
     * @param int $mode
     *
     * @return static
     *
     * @see array_filter()
     */
    public function filter(?callable $callback = null, int $mode = 0): self
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
    public function first(?callable $callback = null, $default = null)
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
     * {@inheritDoc}
     *
     * @see IteratorAggregate::getIterator
     */
    #[\ReturnTypeWillChange]
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
    public function implode(string $glue = '', ?string $lastGlue = null): string
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
     * Return a new collection made up of key values from this collection, where the keys also exist in the other arrays or collections
     *
     * @param ...$others
     *
     * @return static
     *
     * @see array_intersect_key()
     */
    public function intersectKeys(...$others): self
    {
        foreach ($others as $key => $other) {
            $others[$key] = static::castArray($other);
        }
        $first = array_shift($others);
        return new static(array_intersect_key($this->data, $first, ...$others));
    }

    /**
     * Return a new collection made up of key values from this collection, where the keys also exist in the other arrays or collections
     * Uses a callback to decide if the keys are equal
     *
     * @param callable $callback
     * @param ...$others
     *
     * @return static
     *
     * @see array_intersect_ukey()
     */
    public function intersectKeysCallback(callable $callback, ...$others): self
    {
        foreach ($others as $key => $other) {
            $others[$key] = static::castArray($other);
        }
        $first = array_shift($others);
        $others[] = $callback;
        return new static(array_intersect_ukey($this->data, $first, ...$others));
    }

    /**
     * Return a new collection made up of key values from this collection, where the value also exist in the other arrays or collections
     *
     * @param ...$others
     *
     * @return static
     *
     * @see array_intersect()
     */
    public function intersectValues(...$others): self
    {
        foreach ($others as $key => $other) {
            $others[$key] = static::castArray($other);
        }
        $first = array_shift($others);
        return new static(array_intersect($this->data, $first, ...$others));
    }

    /**
     * Return a new collection made up of key values from this collection, where the key/value combination also exist in the other arrays or collections
     *
     * @param ...$others
     *
     * @return static
     *
     * @see array_intersect_assoc()
     */
    public function intersectValuesAndKeys(...$others): self
    {
        foreach ($others as $key => $other) {
            $others[$key] = static::castArray($other);
        }
        $first = array_shift($others);
        return new static(array_intersect_assoc($this->data, $first, ...$others));
    }

    /**
     * Return a new collection made up of key values from this collection, where the key/value combination also exist in the other arrays or collections
     * Uses a callback to determine if keys match
     *
     * @param callable $key_compare_func
     * @param ...$others
     *
     * @return static
     *
     * @see array_intersect_uassoc()
     */
    public function intersectValuesAndKeysCallback(callable $key_compare_func, ...$others): self
    {
        foreach ($others as $key => $other) {
            $others[$key] = static::castArray($other);
        }
        $first = array_shift($others);
        $others[] = $key_compare_func;
        return new static(array_intersect_uassoc($this->data, $first, ...$others));
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
    public function last(?callable $callback = null, $default = null)
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
     * Merge in other collections or arrays
     *
     * @param ...$others
     *
     * @return static
     *
     * @see array_merge()
     */
    public function merge(...$others): self
    {
        foreach ($others as $key => $other) {
            $others[$key] = static::castArray($other);
        }
        $this->data = array_merge($this->data, ...$others);
        return $this;
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
    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return array_get($this->data, $offset);
    }

    /**
     * {@inheritDoc}
     *
     * @see ArrayAccess::offsetSet
     */
    #[\ReturnTypeWillChange]
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
    #[\ReturnTypeWillChange]
    public function offsetUnset($offset)
    {
        array_unset($this->data, $offset);
    }

    /**
     * Pad collection to the specified length with a value
     *
     * @param int $length
     * @param $value
     *
     * @return static
     *
     * @see array_pad()
     */
    public function pad(int $length, $value = null): self
    {
        return new static(array_pad($this->data, $length, $value));
    }

    /**
     * Pop the last item from the collection
     *
     * @return mixed|null
     *
     * @see array_pop()
     */
    public function pop()
    {
        return array_pop($this->data);
    }

    /**
     * Push items onto the end of the collection
     *
     * @param ...$values
     *
     * @return static
     *
     * @see array_push()
     */
    public function push(...$values): self
    {
        foreach ($values as $value) {
            $this->data[] = $value;
        }
        return $this;
    }

    /**
     * Iteratively reduce the collection to a single value using a callback function
     *
     * @param callable $callback
     * @param null $initial
     *
     * @return mixed
     *
     * @see array_reduce()
     */
    public function reduce(callable $callback, $initial = null)
    {
        return array_reduce($this->data, $callback, $initial);
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
     * Shift the first item from the collection
     *
     * @return mixed|null
     *
     * @see array_shift()
     */
    public function shift()
    {
        return array_shift($this->data);
    }

    /**
     * Extract a slice of the collection
     *
     * @return static
     *
     * @see array_slice()
     */
    public function slice(int $offset, ?int $length = null, bool $preserve_keys = true): self
    {
        return new static(array_slice($this->data, $offset, $length, $preserve_keys));
    }

    /**
     * Sort the array by values, either ascending or with a callback
     *
     * @param callable|null $callback
     *
     * @return static
     *
     * @see Collection::sortValues()
     * @see Collection::sortValuesCallback()
     */
    public function sort(?callable $callback = null): self
    {
        return $callback === null ? $this->sortValues() : $this->sortValuesCallback($callback);
    }

    /**
     * Sort the collections keys
     *
     * @param int $order
     * @param int $flags
     *
     * @return static
     *
     * @see ksort()
     * @see krsort()
     */
    public function sortKeys(int $order = SORT_ASC, int $flags = SORT_REGULAR): self
    {
        if ($order === SORT_ASC) {
            ksort($this->data, $flags);
        } else {
            krsort($this->data, $flags);
        }
        return $this;
    }

    /**
     * Sort the array keys using a callback
     *
     * @return static
     *
     * @see uksort()
     */
    public function sortKeysCallback(callable $callback): self
    {
        uksort($this->data, $callback);
        return $this;
    }

    /**
     * Sort the collections values
     *
     * @param int $order
     * @param bool $keepKeys
     * @param int $flags
     *
     * @return self
     *
     * @see sort()
     * @see asort()
     * @see rsort()
     * @see arsort()
     */
    public function sortValues(int $order = SORT_ASC, bool $keepKeys = true, int $flags = SORT_REGULAR): self
    {
        if ($order === SORT_ASC && $keepKeys) {
            asort($this->data, $flags);
        } elseif ($order === SORT_ASC && !$keepKeys) {
            sort($this->data, $flags);
        } elseif ($order === SORT_DESC && $keepKeys) {
            arsort($this->data, $flags);
        } else {
            rsort($this->data, $flags);
        }
        return $this;
    }

    /**
     * Sort the array values using a callback
     *
     * @return static
     *
     * @see usort()
     * @see uasort()
     */
    public function sortValuesCallback(callable $callback, bool $keepKeys = true): self
    {
        if ($keepKeys) {
            uasort($this->data, $callback);
        } else {
            usort($this->data, $callback);
        }
        return $this;
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

    /**
     * Prepend one or more items to the beginning of the collection.
     *
     * @param  ...$values
     *
     * @return static
     *
     * @see array_unshift()
     */
    public function unshift(...$values): self
    {
        $first = array_shift($values);
        array_unshift($this->data, $first, ...$values);
        return $this;
    }

    /**
     * Return a new collection of just the values
     *
     * @return static
     *
     * @see array_values()
     */
    public function values(): self
    {
        return new static(array_values($this->data));
    }
}
