# Coding Standards

This library follows [PSR-1](https://www.php-fig.org/psr/psr-1/) & [PSR-2](https://www.php-fig.org/psr/psr-2/) standards.

# Unit tests

When adding a new function, please ensure you add a unit test specifically for it.

If possible, aim for 100% code coverage.

If modifying a function, please add a unit test for the new functionality (if applicable) and ensure existing tests have not been broken.

The full test suite can be run with the following command

```bash
vendor/bin/phpunit
```

Or you can run partial tests using groups

```bash
vendor/bin/phpunit --group arrays
```

# Running the benchmarks

When adding a new function, please ensure you add benchmarks specifically for it.

If modifying a function, try to ensure the benchmarks do not get slower (within reason)

The full benchmark suite can be run with the following command

```bash
vendor/bin/phpbench run --report quick
```

Or you can run partial benchmarks by setting a file or directory

```bash
vendor/bin/phpbench run --report quick benchmarks/Functions/Arrays/
```

# Code sniffer

**Please only run the code sniffer if you are using PHP 5**

```bash
vendor/bin/phpcbf .
```