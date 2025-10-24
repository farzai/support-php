# Support Package - PHP

[![Latest Version on Packagist](https://img.shields.io/packagist/v/farzai/support.svg?style=flat-square)](https://packagist.org/packages/farzai/support)
[![Tests](https://img.shields.io/github/actions/workflow/status/farzai/support-php/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/farzai/support-php/actions/workflows/run-tests.yml)
[![codecov](https://codecov.io/gh/farzai/support-php/branch/main/graph/badge.svg)](https://codecov.io/gh/farzai/support-php)
[![Total Downloads](https://img.shields.io/packagist/dt/farzai/support.svg?style=flat-square)](https://packagist.org/packages/farzai/support)

A collection of useful PHP helper functions and utilities with full type safety and comprehensive documentation.

## Features

- 🔒 **Fully Typed** - Complete PHP 8.0+ type declarations for enhanced IDE support
- 📝 **Well Documented** - Comprehensive PHPDoc comments with examples
- ✅ **Thoroughly Tested** - High test coverage with edge case testing
- 🔍 **Static Analysis** - PHPStan Level 8 compliant
- 🎯 **Zero Dependencies** - Only requires Carbon for date/time utilities
- 🌐 **UTF-8 Safe** - Multi-byte string operations throughout

## Requirements

- PHP 8.0 or higher
- ext-mbstring

## Installation

You can install the package via composer:

```bash
composer require farzai/support
```

## Table of Contents

- [Array Utilities](#array-utilities)
- [String Utilities](#string-utilities)
- [Date/Time Utilities](#datetime-utilities)
- [Helper Functions](#helper-functions)

## Array Utilities

The `Arr` class provides utilities for working with arrays using dot notation.

### get()

Get an item from an array using dot notation:

```php
use Farzai\Support\Arr;

$array = [
    'user' => [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'address' => [
            'city' => 'New York'
        ]
    ]
];

// Get nested value
Arr::get($array, 'user.name'); // Returns: 'John Doe'
Arr::get($array, 'user.address.city'); // Returns: 'New York'

// With default value
Arr::get($array, 'user.phone', 'N/A'); // Returns: 'N/A'

// Get entire array
Arr::get($array, null); // Returns: entire $array
```

### exists()

Check if a key exists in an array using dot notation:

```php
use Farzai\Support\Arr;

$array = ['user' => ['name' => 'John']];

Arr::exists($array, 'user.name'); // Returns: true
Arr::exists($array, 'user.email'); // Returns: false
```

### accessible()

Check if a value is array accessible:

```php
use Farzai\Support\Arr;

Arr::accessible(['foo' => 'bar']); // Returns: true
Arr::accessible(new ArrayObject()); // Returns: true
Arr::accessible('string'); // Returns: false
```

## String Utilities

The `Str` class provides a rich set of string manipulation methods.

### Case Conversion

```php
use Farzai\Support\Str;

// camelCase
Str::camel('foo_bar'); // Returns: 'fooBar'
Str::camel('foo-bar'); // Returns: 'fooBar'

// StudlyCase (PascalCase)
Str::studly('foo_bar'); // Returns: 'FooBar'

// snake_case
Str::snake('fooBar'); // Returns: 'foo_bar'
Str::snake('FooBar', '-'); // Returns: 'foo-bar'

// lowercase
Str::lower('FOO BAR'); // Returns: 'foo bar'
```

### Case Checking

```php
use Farzai\Support\Str;

Str::isSnakeCase('foo_bar'); // Returns: true
Str::isCamelCase('fooBar'); // Returns: true
Str::isStudlyCase('FooBar'); // Returns: true
```

### String Operations

```php
use Farzai\Support\Str;

// Replace
Str::replace('foo', 'bar', 'foo baz'); // Returns: 'bar baz'

// Check if starts with
Str::startsWith('foobar', 'foo'); // Returns: true
Str::startsWith('foobar', ['bar', 'foo']); // Returns: true

// Check if ends with
Str::endsWith('foobar', 'bar'); // Returns: true

// Check if contains
Str::contains('foobar', 'oob'); // Returns: true
Str::contains('foobar', ['baz', 'bar']); // Returns: true

// Length (UTF-8 safe)
Str::length('foo'); // Returns: 3
Str::length('ñoño'); // Returns: 4

// Substring (UTF-8 safe)
Str::substr('foobar', 0, 3); // Returns: 'foo'
Str::substr('foobar', 3); // Returns: 'bar'
```

### Random String Generation

All random methods use cryptographically secure randomness:

```php
use Farzai\Support\Str;

// Random alphanumeric (base64-like)
Str::random(16); // Returns: 'a3K7mN9pQ1xY2zB5'

// Random ASCII
Str::randomAscii(16);

// Random numeric only
Str::randomNumeric(6); // Returns: '472891'

// Random alphanumeric (A-Z, a-z, 0-9)
Str::randomAlphanumeric(12); // Returns: 'aB3xY9mK2nP7'

// Random with custom character set
Str::randomString(8, 'ABCD123'); // Returns: 'A2B1C3D2'

// Random with special characters (for passwords)
Str::randomStringWithSpecialCharacter(16); // Returns: 'aB3!xY@9#mK2$pQ5'
```

## Date/Time Utilities

The `Carbon` class extends the popular Carbon library with additional convenience methods.

### Creating Instances

```php
use Farzai\Support\Carbon;
use function Farzai\Support\now;

// Get current date/time
$now = now();
// or
$now = Carbon::now();

// With timezone
$now = now('America/New_York');
$now = Carbon::now('UTC');

// From timestamp
$date = Carbon::fromTimestamp(1609459200);
```

### Date Checking

```php
use Farzai\Support\Carbon;

$today = Carbon::now();
$yesterday = Carbon::yesterday();
$tomorrow = Carbon::tomorrow();

// Check if today
$today->isToday(); // Returns: true
$yesterday->isToday(); // Returns: false

// Check if past
$yesterday->isPast(); // Returns: true
$tomorrow->isPast(); // Returns: false

// Check if future
$tomorrow->isFuture(); // Returns: true
$yesterday->isFuture(); // Returns: false

// Check if between dates
$today->isBetweenDates($yesterday, $tomorrow); // Returns: true
```

### Date Formatting

```php
use Farzai\Support\Carbon;

$date = Carbon::now();

// Format as date string
$date->toDateString(); // Returns: '2024-03-18'

// Format as time string
$date->toTimeString(); // Returns: '14:30:45'

// Format as datetime string
$date->toDateTimeString(); // Returns: '2024-03-18 14:30:45'
```

### Day Boundaries

```php
use Farzai\Support\Carbon;

$date = Carbon::now();

// Start of day
$start = $date->startOfDay(); // Returns: today at 00:00:00

// End of day
$end = $date->endOfDay(); // Returns: today at 23:59:59
```

### Date Differences

```php
use Farzai\Support\Carbon;

$today = Carbon::now();
$yesterday = Carbon::yesterday();

// Absolute difference in days
$today->diffInDaysAbsolute($yesterday); // Returns: 1
```

## Helper Functions

Global helper functions in the `Farzai\Support` namespace.

### tap()

Execute a callback on a value and return the value:

```php
use function Farzai\Support\tap;

// With callback
$user = tap($user, function ($u) {
    $u->update(['last_login' => now()]);
});
// Returns $user after updating

// Without callback (higher-order proxy)
$user = tap($user)
    ->update(['last_login' => now()])
    ->save();
// Chains methods but returns $user
```

### now()

Get the current date/time:

```php
use function Farzai\Support\now;

$current = now(); // Returns: Carbon instance
$ny = now('America/New_York'); // Returns: Carbon instance in NY timezone
```

### class_basename()

Get the class name without namespace:

```php
use function Farzai\Support\class_basename;

class_basename('App\Models\User'); // Returns: 'User'
class_basename(new \App\Models\User); // Returns: 'User'
```

## Development

### Running Tests

```php
composer test
```

### Running Tests with Coverage

```bash
composer test-coverage
```

### Code Formatting

```bash
composer format
```

### Static Analysis

```bash
composer analyze
```

### Run All Checks

```bash
composer check
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/farzai/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [parsilver](https://github.com/parsilver)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
