PHPUnit Sample Code
===================

The demonstration of PHPUnit

INSTALLATION
------------

Create the project by Composer:

```
composer create-project --prefer-dist --stability=dev yidas/phpunit-sample
```

USAGE
-----

In the root directory of this library, run `phpunit` from vendor:

```
./vendor/bin/phpunit
```

Then the result would like:

```
PHPUnit 5.6.4 by Sebastian Bergmann and contributors.

...                                                                 3 / 3 (100%)

Time: 32 ms, Memory: 3.50MB

OK (3 tests, 3 assertions)
```

DIRECTORY STRUCTURE
-------------------

```
src/      Source component classes
tests/    Test cases
```

DOCUMENTATION
-------------

- [Getting Started with PHPUnit 5](https://phpunit.de/getting-started/phpunit-5.html)

- [PHPUnit APPENDIX - 3. The XML Configuration File](https://phpunit.readthedocs.io/en/7.1/configuration.html)

- [PHPUnit APPENDIX - 1. Assertions](https://phpunit.readthedocs.io/en/7.1/assertions.html)
