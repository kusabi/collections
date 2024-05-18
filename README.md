# A wrapper class for PHP native arrays

![Tests](https://github.com/kusabi/collections/workflows/quality/badge.svg)
[![codecov](https://codecov.io/gh/kusabi/collections/branch/main/graph/badge.svg)](https://codecov.io/gh/kusabi/collections)
[![Licence Badge](https://img.shields.io/github/license/kusabi/collections.svg)](https://img.shields.io/github/license/kusabi/collections.svg)
[![Release Badge](https://img.shields.io/github/release/kusabi/collections.svg)](https://img.shields.io/github/release/kusabi/collections.svg)
[![Tag Badge](https://img.shields.io/github/tag/kusabi/collections.svg)](https://img.shields.io/github/tag/kusabi/collections.svg)
[![Issues Badge](https://img.shields.io/github/issues/kusabi/collections.svg)](https://img.shields.io/github/issues/kusabi/collections.svg)
[![Code Size](https://img.shields.io/github/languages/code-size/kusabi/collections.svg?label=size)](https://img.shields.io/github/languages/code-size/kusabi/collections.svg)

<sup>A library that extends PHP's native string functionality</sup>

## Compatibility and dependencies

This library is compatible with PHP version `7.2`, `7.3`, `7.4`, `8.0`, `8.1`, `8.2` and `8.3`.

This library has no dependencies.

## Installation

Installation is simple using composer.

```bash
composer require kusabi/collections
```

Or simply add it to your `composer.json` file

```json
{
    "require": {
        "kusabi/collections": "^1.0"
    }
}
```

## Contributing

This library follows [PSR-1](https://www.php-fig.org/psr/psr-1/) & [PSR-2](https://www.php-fig.org/psr/psr-2/) standards.


#### Unit Tests

Before pushing any changes, please ensure the unit tests are all passing.

If possible, feel free to improve coverage in a separate commit.

```bash
vendor/bin/phpunit
```

#### Code sniffer

Before pushing, please ensure you have run the code sniffer. **Only run it using the lowest support PHP version (7.2)**

```bash
vendor/bin/php-cs-fixer fix
```

#### Static Analyses

Before pushing, please ensure you have run the static analyses tool.

```bash
vendor/bin/phan
```

#### Benchmarks

Before pushing, please ensure you have checked the benchmarks and ensured that your code has not introduced any slowdowns.

Feel free to speed up existing code, in a separate commit.

Feel free to add more benchmarks for greater coverage, in a separate commit.

```bash
vendor/bin/phpbench run --report=speed
vendor/bin/phpbench run --report=speed --output=markdown
vendor/bin/phpbench run --report=speed --filter=benchNetFromTax --iterations=50 --revs=50000

vendor/bin/phpbench xdebug:profile
vendor/bin/phpbench xdebug:profile --gui
```


## Documentation

This library adds a new class that can wrap around native arrays to mke interactions with them quicker and simpler.

Below you can find links to the documentation for the new features.


### Creating an instance of the collection

```php
use Kusabi\Collection\Collection;

// Using the constructor
$collection = new Collection();
$collection = new Collection([1, 2, 3]);

// Using the chainable constructor
$collection = Collection::instance();
$collection = Collection::instance([1, 2, 3]);

// Create using a range
$celsius = Collection::range(0, 100);
$alphabet = Collection::range('a', 'z');
$evens = Collection::range(0, 100, 2);
```


### Getting data from a collection

```php
use Kusabi\Collection\Collection;

// Collections can be used exactly like a normal array
$collection = new Collection([1, 2, 3]);
$collection[] = 4;
$collection['test'] = 5;
echo $collection[1]; // 2 

// Getting the size of the collection
echo count($collection); // 5
echo $collection->count(); // 5

// Get the underlying array
$array = $collection->array();


```


### A list of native methods integrated into this class

**[array_change_key_case](https://www.php.net/manual/en/function.array-change-key-case.php)** Changes the case of all keys in an array
```php
use Kusabi\Collection\Collection;

$collection = new Collection(["FirSt" => 1, "SecOnd" => 4]);

$collection->changeKeyCase(CASE_UPPER); // ["FIRST" => 1, "SECOND" => 4]
$collection->changeKeyCase(CASE_LOWER); // ["first" => 1, "second" => 4]
```

**[array_chunk](https://www.php.net/manual/en/function.array-chunk.php)** Split an array into chunks
```php
use Kusabi\Collection\Collection;

$collection = Collection::range(1, 100);
$chunks = $collection->chunk(10);
```

**[array_column](https://www.php.net/manual/en/function.array-column.php)** Return the values from a single column in the input array
```php
use Kusabi\Collection\Collection;

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
$hps = $collection->column('hp'); // [50, 70]
$hps = $collection->column('hp', 'name'); // ['John' => 50, 'Jane' => 70]
```

**[array_combine](https://www.php.net/manual/en/function.array-combine.php)** Creates an array by using one array for keys and another for its values
```php
use Kusabi\Collection\Collection;

$keys = new Collection(['a', 'b', 'c'])
$combinedWithArray = $keys->combine(['x', 'y', 'z']);
$combinedWithCollection = $keys->combine(new Collection(['x', 'y', 'z']));
```

**[array_count_values](https://www.php.net/manual/en/function.array-count-values.php)** Counts all the values of an array
```php
use Kusabi\Collection\Collection;

$collection = new Collection([1, 2, 3, 1, 2, 4, 'a', 'a', 1]);

$appearances = $collection->countValues(); // [1 => 3, 2 => 2, 3 => 1, 4 => 1, 'a' => 2]
```

**[array_diff_assoc](https://www.php.net/manual/en/function.array-diff-assoc.php)** Computes the difference of arrays with additional index check
```php
// Add documentation
```

**[array_diff_key](https://www.php.net/manual/en/function.array-diff-key.php)** Computes the difference of arrays using keys for comparison
```php
// Add documentation
```

**[array_diff_uassoc](https://www.php.net/manual/en/function.array-diff-uassoc.php)** Computes the difference of arrays with additional index check which is performed by a user supplied callback function
```php
// Add documentation
```

**[array_diff_ukey](https://www.php.net/manual/en/function.array-diff-ukey.php)** Computes the difference of arrays using a callback function on the keys for comparison
```php
// Add documentation
```

**[array_diff](https://www.php.net/manual/en/function.array-diff.php)** Computes the difference of arrays
```php
use Kusabi\Collection\Collection;

$collection = new Collection([1, 2, 3, 4, 5, 6]);
$diff = $collection->diff([3, 4, 5]);
$diff = $collection->diff(new Collection([3, 4, 5]));
```

**[array_fill_keys](https://www.php.net/manual/en/function.array-fill-keys.php)** Fill an array with values, specifying keys
```php
// Add documentation
```

**[array_fill](https://www.php.net/manual/en/function.array-fill.php)** Fill an array with values
```php
// Add documentation
```

**[array_filter](https://www.php.net/manual/en/function.array-filter.php)** Filters elements of an array using a callback function
```php
use Kusabi\Collection\Collection;

$collection = new Collection([1, 2, 3, 4, 5, 6, null]);

$collection->filter();
$collection->filter(function ($item) {
    return $item > 3;
});
```

**[array_flip](https://www.php.net/manual/en/function.array-flip.php)** Exchanges all keys with their associated values in an array
```php
use Kusabi\Collection\Collection;

$collection = new Collection(['a', 'b', 'c']);
$flipped = $collection->flip(); // ['a' => 0, 'b' => 1, 'c' => 2]

$collection = new Collection(['a', 'b', 'c', 'a']);
$flipped = $collection->flip(); // ['a' => 0, 'b' => 1, 'c' => 2]
$doubleFlipped = $collection->flip()->flip(); // ['a' => 0, 'b' => 1, 'c' => 2]
```

**[array_intersect_assoc](https://www.php.net/manual/en/function.array-intersect-assoc.php)** Computes the intersection of arrays with additional index check
```php
// Add documentation
```

**[array_intersect_key](https://www.php.net/manual/en/function.array-intersect-key.php)** Computes the intersection of arrays using keys for comparison
```php
// Add documentation
```

**[array_intersect_uassoc](https://www.php.net/manual/en/function.array-intersect-uassoc.php)** Computes the intersection of arrays with additional index check, compares indexes by a callback function
```php
// Add documentation
```

**[array_intersect_ukey](https://www.php.net/manual/en/function.array-intersect-ukey.php)** Computes the intersection of arrays using a callback function on the keys for comparison
```php
// Add documentation
```

**[array_intersect](https://www.php.net/manual/en/function.array-intersect.php)** Computes the intersection of arrays
```php
// Add documentation
```

**[array_is_list](https://www.php.net/manual/en/function.array-is-list.php)** Checks whether a given array is a list
```php
use Kusabi\Collection\Collection;

Collection::instance(['a', 'b', 'c'])->isList(); // true
Collection::instance(['a' => 1, 'b', 'c'])->isList(); // false
```

**[array_key_exists](https://www.php.net/manual/en/function.array-key-exists.php)** Checks if the given key or index exists in the array
```php
use Kusabi\Collection\Collection;

$collection = new Collection([
    'a' => 1,
    'b' => 2,
    'c' => [
        'a' => 1,
        'b' => null,
        'c' => 3,
    ],
]);
$collection->exists('a'); // true
$collection->exists('z'); // false
$collection->exists('c.a'); // true
$collection->exists('c.b'); // true
$collection->exists('c.z'); // false
```

**[array_key_first](https://www.php.net/manual/en/function.array-key-first.php)** Gets the first key of an array
```php
use Kusabi\Collection\Collection;

$collection = new Collection(['a' => 1, 'b' => 2, 'c' => 3]);
echo $collection->keys()->first(); // 'a'
```

**[array_key_last](https://www.php.net/manual/en/function.array-key-last.php)** Gets the last key of an array
```php
use Kusabi\Collection\Collection;

$collection = new Collection(['a' => 1, 'b' => 2, 'c' => 3]);
echo $collection->keys()->last(); // 'c'
```

**[array_keys](https://www.php.net/manual/en/function.array-keys.php)** Return all the keys or a subset of the keys of an array
```php
use Kusabi\Collection\Collection;

$collection = new Collection([
    'a' => 1,
    'b' => 2,
    'c' => [
        'a' => 1,
        'b' => null,
        'c' => 3,
    ],
]);

$collection->keys(); // ['a', 'b', 'c']

$collection->keys(true); // ['a', 'b', 'c.a', 'c.b', 'c.c']
```

**[array_map](https://www.php.net/manual/en/function.array-map.php)** Applies the callback to the elements of the given arrays
```php
use Kusabi\Collection\Collection;

$collection = new Collection([
    'a' => 1,
    'b' => 2,
    'c' => 3
]);

$increased = $collection->map(function ($value) {
    return $value * 2;
}); // ['a' => 2, 'b' => 4, 'c' => 6]

$concatenatedKeys = $collection->map(function ($value, $key) {
    return $key.'-'.$value;
}); // ['a' => 'a-1', 'b' => 'b-2', 'c' => 'c-3']
```

**[array_merge_recursive](https://www.php.net/manual/en/function.array-merge-recursive.php)** Merge one or more arrays recursively
```php
// Add documentation
```

**[array_merge](https://www.php.net/manual/en/function.array-merge.php)** Merge one or more arrays
```php
// Add documentation
```

**[array_multisort](https://www.php.net/manual/en/function.array-multisort.php)** Sort multiple or multi-dimensional arrays
```php
// Add documentation
```

**[array_pad](https://www.php.net/manual/en/function.array-pad.php)** Pad array to the specified length with a value
```php
// Add documentation
```

**[array_pop](https://www.php.net/manual/en/function.array-pop.php)** Pop the element off the end of array
```php
use Kusabi\Collection\Collection;

$collection = new Collection([1, 2, 3, 4]);
$popped = $collection->pop(); // [1, 2, 3]
echo $popped; // 4
```

**[array_product](https://www.php.net/manual/en/function.array-product.php)** Calculate the product of values in an array
```php
// Add documentation
```

**[array_push](https://www.php.net/manual/en/function.array-push.php)** Push one or more elements onto the end of array
```php
use Kusabi\Collection\Collection;

$collection = new Collection([1, 2, 3, 4]);
$collection->push(5, 6, 7, 8); // [1, 2, 3, 4, 5, 6, 7, 8]
```

**[array_rand](https://www.php.net/manual/en/function.array-rand.php)** Pick one or more random keys out of an array
```php
// Add documentation
```

**[array_reduce](https://www.php.net/manual/en/function.array-reduce.php)** Iteratively reduce the array to a single value using a callback function
```php
use Kusabi\Collection\Collection;

$ten_factorial = Collection::range(1, 10)->reduce(function ($carry, $value) {
    return $carry * $value;
}, 1); // 3628800
```

**[array_replace_recursive](https://www.php.net/manual/en/function.array-replace-recursive.php)** Replaces elements from passed arrays into the first array recursively
```php
// Add documentation
```

**[array_replace](https://www.php.net/manual/en/function.array-replace.php)** Replaces elements from passed arrays into the first array
```php
// Add documentation
```

**[array_reverse](https://www.php.net/manual/en/function.array-reverse.php)** Return an array with elements in reverse order
```php
use Kusabi\Collection\Collection;

$collection = new Collection([
    'a' => 1,
    'b' => 2,
    'c' => 3
]);

$reversedCopy = $collection->reverse(); // ['c' => 3, 'b' => 2, 'a' => 1]
```

**[array_search](https://www.php.net/manual/en/function.array-search.php)** Searches the array for a given value and returns the first corresponding key if successful
```php
// Add documentation
```

**[array_shift](https://www.php.net/manual/en/function.array-shift.php)** Shift an element off the beginning of array
```php
use Kusabi\Collection\Collection;

$collection = new Collection([1, 2, 3, 4]);
$shifted = $collection->shift(); // [2, 3, 4]
echo $shifted; // 1
```

**[array_slice](https://www.php.net/manual/en/function.array-slice.php)** Extract a slice of the array
```php
// Add documentation
```

**[array_splice](https://www.php.net/manual/en/function.array-splice.php)** Remove a portion of the array and replace it with something else
```php
// Add documentation
```

**[array_sum](https://www.php.net/manual/en/function.array-sum.php)** Calculate the sum of values in an array
```php
use Kusabi\Collection\Collection;

$sum = Collection::instance([1, 2, 3])->sum(); // 6
$sum = Collection::range(1, 100)->sum(); // 5050
```

**[array_udiff_assoc](https://www.php.net/manual/en/function.array-udiff-assoc.php)** Computes the difference of arrays with additional index check, compares data by a callback function
```php
// Add documentation
```

**[array_udiff_uassoc](https://www.php.net/manual/en/function.array-udiff-uassoc.php)** Computes the difference of arrays with additional index check, compares data and indexes by a callback function
```php
// Add documentation
```

**[array_udiff](https://www.php.net/manual/en/function.array-udiff.php)** Computes the difference of arrays by using a callback function for data comparison
```php
// Add documentation
```

**[array_uintersect_assoc](https://www.php.net/manual/en/function.array-uintersect-assoc.php)** Computes the intersection of arrays with additional index check, compares data by a callback function
```php
// Add documentation
```

**[array_uintersect_uassoc](https://www.php.net/manual/en/function.array-uintersect-uassoc.php)** Computes the intersection of arrays with additional index check, compares data and indexes by separate callback functions
```php
// Add documentation
```

**[array_uintersect](https://www.php.net/manual/en/function.array-uintersect.php)** Computes the intersection of arrays, compares data by a callback function
```php
// Add documentation
```

**[array_unique](https://www.php.net/manual/en/function.array-unique.php)** Removes duplicate values from an array
```php
// Add documentation
```

**[array_unshift](https://www.php.net/manual/en/function.array-unshift.php)** Prepend one or more elements to the beginning of an array
```php
use Kusabi\Collection\Collection;

$collection = new Collection([1, 2, 3, 4]);
$collection->unshift(5, 6, 7, 8); // [5, 6, 7, 8, 1, 2, 3, 4]
```

**[array_values](https://www.php.net/manual/en/function.array-values.php)** Return all the values of an array
```php
use Kusabi\Collection\Collection;

$collection = new Collection(['a' => 1, 'b' => 2, 'c' => 3]);
$collection->values(5, 6, 7, 8); // [1, 2, 3]
```

**[array_walk_recursive](https://www.php.net/manual/en/function.array-walk-recursive.php)** Apply a user function recursively to every member of an array
```php
// Add documentation
```

**[array_walk](https://www.php.net/manual/en/function.array-walk.php)** Apply a user supplied function to every member of an array
```php
// Add documentation
```

~~**[array](https://www.php.net/manual/en/function.array.php)** Create an array~~


**[arsort](https://www.php.net/manual/en/function.arsort.php)** Sort an array in descending order and maintain index association
```php
// Add documentation
```

**[asort](https://www.php.net/manual/en/function.asort.php)** Sort an array in ascending order and maintain index association
```php
// Add documentation
```

**[compact](https://www.php.net/manual/en/function.compact.php)** Create array containing variables and their values
```php
// Add documentation
```

**[count](https://www.php.net/manual/en/function.count.php)** Counts all elements in an array or in a Countable object
```php
use Kusabi\Collection\Collection;

$collection = new Collection([1, 2, 3]);

count($collection); // 3
$collection->count(); // 3
```

**[current](https://www.php.net/manual/en/function.current.php)** Return the current element in an array
```php
// Add documentation
```

**[each](https://www.php.net/manual/en/function.each.php)** Return the current key and value pair from an array and advance the array cursor
```php
// Add documentation
```

**[end](https://www.php.net/manual/en/function.end.php)** Set the internal pointer of an array to its last element
```php
// Add documentation
```

**[extract](https://www.php.net/manual/en/function.extract.php)** Import variables into the current symbol table from an array
```php
use Kusabi\Collection\Collection;

$collection = new Collection(['a' => 1, 'b' => 2]);
extract($collection->array()); // No way to get the new variables into the caller scope. If we have collection->extract() then the variables will be created into the method scope
```

**[implode](https://www.php.net/manual/en/function.implode.php)** Join array elements with a string
```php
use Kusabi\Collection\Collection;

echo Collection::instance('a', 'b', 'c')->implode(', '); // "a, b, c"
echo Collection::instance('a', 'b', 'c')->implode(', ', ' and '); // "a, b and c"
```

**[in_array](https://www.php.net/manual/en/function.in-array.php)** Checks if a value exists in an array
```php
use Kusabi\Collection\Collection;

$collection = new Collection([4, 5, 6]);
$collection->contains(5);
```

**[key_exists](https://www.php.net/manual/en/function.key-exists.php)** Alias of array_key_exists
```php
use Kusabi\Collection\Collection;

$collection = new Collection([
    'a' => 1,
    'b' => 2,
    'c' => [
        'a' => 1,
        'b' => null,
        'c' => 3,
    ],
]);
$collection->exists('a'); // true
$collection->exists('z'); // false
$collection->exists('c.a'); // true
$collection->exists('c.b'); // true
$collection->exists('c.z'); // false
```

**[key](https://www.php.net/manual/en/function.key.php)** Fetch a key from an array
```php
// Add documentation
```

**[krsort](https://www.php.net/manual/en/function.krsort.php)** Sort an array by key in descending order
```php
// Add documentation
```

**[ksort](https://www.php.net/manual/en/function.ksort.php)** Sort an array by key in ascending order
```php
// Add documentation
```

**[list](https://www.php.net/manual/en/function.list.php)** Assign variables as if they were an array
```php
// Add documentation
```

**[natcasesort](https://www.php.net/manual/en/function.natcasesort.php)** Sort an array using a case insensitive "natural order" algorithm
```php
// Add documentation
```

**[natsort](https://www.php.net/manual/en/function.natsort.php)** Sort an array using a "natural order" algorithm
```php
// Add documentation
```

**[next](https://www.php.net/manual/en/function.next.php)** Advance the internal pointer of an array
```php
// Add documentation
```

**[pos](https://www.php.net/manual/en/function.pos.php)** Alias of current
```php
// Add documentation
```

**[prev](https://www.php.net/manual/en/function.prev.php)** Rewind the internal array pointer
```php
// Add documentation
```

**[range](https://www.php.net/manual/en/function.range.php)** Create an array containing a range of elements
```php
use Kusabi\Collection\Collection;

$numbers = Collection::range(0, 100);
$even = Collection::range(0, 100, 2);
$alphabet = Collection::range('a', 'z');
```

**[reset](https://www.php.net/manual/en/function.reset.php)** Set the internal pointer of an array to its first element
```php
// Add documentation
```

**[rsort](https://www.php.net/manual/en/function.rsort.php)** Sort an array in descending order
```php
// Add documentation
```

**[shuffle](https://www.php.net/manual/en/function.shuffle.php)** Shuffle an array
```php
// Add documentation
```

**[sizeof](https://www.php.net/manual/en/function.sizeof.php)** Alias of count
```php
use Kusabi\Collection\Collection;

$collection = new Collection([1, 2, 3]);

count($collection); // 3
$collection->count(); // 3
```

**[sort](https://www.php.net/manual/en/function.sort.php)** Sort an array in ascending order
```php
// Add documentation
```

**[uasort](https://www.php.net/manual/en/function.uasort.php)** Sort an array with a user-defined comparison function and maintain index association
```php
// Add documentation
```

**[uksort](https://www.php.net/manual/en/function.uksort.php)** Sort an array by keys using a user-defined comparison function
```php
// Add documentation
```

**[usort](https://www.php.net/manual/en/function.usort.php)** Sort an array by values using a user-defined comparison function
```php
// Add documentation
```
