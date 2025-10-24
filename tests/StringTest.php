<?php

declare(strict_types=1);

use Farzai\Support\Str;

it('can convert string to camel case', function () {
    expect(Str::camel('foo_bar_baz'))->toBe('fooBarBaz');
});

it('can convert string to studly case', function () {
    expect(Str::studly('foo_bar_baz'))->toBe('FooBarBaz');
});

it('can convert string to snake case', function () {
    expect(Str::snake('fooBarBaz'))->toBe('foo_bar_baz');
});

it('can convert string to lower case', function () {
    expect(Str::lower('FooBarBaz'))->toBe('foobarbaz');
});

it('can replace string', function () {
    expect(Str::replace('foo', 'bar', 'foo bar baz'))->toBe('bar bar baz');
});

it('can check if string starts with given value', function () {
    expect(Str::startsWith('foo bar baz', 'foo'))->toBeTrue();
    expect(Str::startsWith('foo bar baz', 'bar'))->toBeFalse();
});

it('can check if string ends with given value', function () {
    expect(Str::endsWith('foo bar baz', 'baz'))->toBeTrue();
    expect(Str::endsWith('foo bar baz', 'bar'))->toBeFalse();
});

it('can check if string is in snake case', function () {
    expect(Str::isSnakeCase('foo_bar_baz'))->toBeTrue();
    expect(Str::isSnakeCase('fooBarBaz'))->toBeFalse();
});

it('can check if string is in camel case', function () {
    expect(Str::isCamelCase('fooBarBaz'))->toBeTrue();
    expect(Str::isCamelCase('foo_bar_baz'))->toBeFalse();
});

it('can check if string is in studly case', function () {
    expect(Str::isStudlyCase('FooBarBaz'))->toBeTrue();
    expect(Str::isStudlyCase('foo_bar_baz'))->toBeFalse();
});

it('can randomize string', function () {
    expect(Str::random(10))->toHaveLength(10);
});

it('can random ascii', function () {
    expect(Str::randomAscii(10))->toHaveLength(10);
});

it('can random numeric', function () {
    expect(Str::randomNumeric(10))->toHaveLength(10);
});

it('can get string length', function () {
    expect(Str::length('foo bar baz'))->toBe(11);
});

it('can get string substring', function () {
    expect(Str::substr('foo bar baz', 0, 3))->toBe('foo');
});

it('can check if string contains given value', function () {
    expect(Str::contains('foo bar baz', 'bar'))->toBeTrue();
    expect(Str::contains('foo bar baz', 'qux'))->toBeFalse();
});

it('can random alphanumeric', function () {
    expect(Str::randomAlphanumeric(10))->toHaveLength(10);
});

it('can random string', function () {
    expect(Str::randomString(10))->toHaveLength(10);
});

it('can random string with numeric', function () {
    expect(Str::randomStringWithNumeric(10))->toHaveLength(10);
});

it('can random string with special characters', function () {
    expect(Str::randomStringWithSpecialCharacter(10))->toHaveLength(10);
});

// Edge case and boundary tests
it('handles empty strings correctly', function () {
    expect(Str::camel(''))->toBe('');
    expect(Str::studly(''))->toBe('');
    expect(Str::snake(''))->toBe('');
    expect(Str::lower(''))->toBe('');
    expect(Str::length(''))->toBe(0);
    expect(Str::substr('', 0))->toBe('');
});

it('handles unicode and multi-byte characters', function () {
    expect(Str::length('ñoño'))->toBe(4);
    expect(Str::length('🔥🔥🔥'))->toBe(3);
    expect(Str::lower('ÑOÑO'))->toBe('ñoño');
    expect(Str::substr('ñoño', 0, 2))->toBe('ño');
    expect(Str::contains('ñoño', 'ño'))->toBeTrue();
});

it('handles startsWith with empty needle', function () {
    expect(Str::startsWith('foobar', ''))->toBeFalse();
    expect(Str::startsWith('foobar', ['', 'foo']))->toBeTrue();
});

it('handles endsWith with empty needle', function () {
    expect(Str::endsWith('foobar', ''))->toBeFalse();
    expect(Str::endsWith('foobar', ['', 'bar']))->toBeTrue();
});

it('handles contains with empty needle', function () {
    expect(Str::contains('foobar', ''))->toBeFalse();
    expect(Str::contains('foobar', ['', 'bar']))->toBeTrue();
});

it('handles very long strings', function () {
    $longString = str_repeat('a', 10000);
    expect(Str::length($longString))->toBe(10000);
    expect(Str::substr($longString, 0, 100))->toHaveLength(100);
    expect(Str::contains($longString, 'aaa'))->toBeTrue();
});

it('handles special characters in strings', function () {
    $special = '!@#$%^&*()_+-=[]{}|;:,.<>?';
    expect(Str::length($special))->toBe(26);
    expect(Str::contains($special, '@'))->toBeTrue();
    expect(Str::startsWith($special, '!'))->toBeTrue();
    expect(Str::endsWith($special, '?'))->toBeTrue();
});

it('handles whitespace in strings', function () {
    expect(Str::length('  foo  '))->toBe(7);
    expect(Str::contains('foo bar', ' '))->toBeTrue();
    expect(Str::snake('foo bar'))->toBe('foo_bar');
});

it('handles case conversion edge cases', function () {
    expect(Str::studly('foo-bar-baz'))->toBe('FooBarBaz');
    expect(Str::snake('fooBarBazQux'))->toBe('foo_bar_baz_qux');
    expect(Str::camel('foo-bar'))->toBe('fooBar');
});

it('verifies random methods produce correct character sets', function () {
    $numeric = Str::randomNumeric(100);
    expect($numeric)->toMatch('/^[0-9]+$/');

    $alphanumeric = Str::randomAlphanumeric(100);
    expect($alphanumeric)->toMatch('/^[A-Za-z0-9]+$/');
});

it('verifies random methods produce consistent length', function () {
    for ($i = 1; $i <= 50; $i++) {
        expect(Str::random($i))->toHaveLength($i);
        expect(Str::randomNumeric($i))->toHaveLength($i);
        expect(Str::randomAlphanumeric($i))->toHaveLength($i);
        expect(Str::randomStringWithSpecialCharacter($i))->toHaveLength($i);
    }
});

it('handles replace with arrays', function () {
    expect(Str::replace(['foo', 'bar'], ['FOO', 'BAR'], 'foo bar'))
        ->toBe('FOO BAR');
});

it('handles substr with negative start', function () {
    expect(Str::substr('foobar', -3))->toBe('bar');
    expect(Str::substr('foobar', -3, 2))->toBe('ba');
});

it('handles case checking edge cases', function () {
    expect(Str::isSnakeCase('foo'))->toBeTrue();
    expect(Str::isCamelCase('foo'))->toBeTrue();
    expect(Str::isStudlyCase('Foo'))->toBeTrue();
    expect(Str::isSnakeCase('foo_bar_baz'))->toBeTrue();
    expect(Str::isCamelCase('fooBar'))->toBeTrue();
    expect(Str::isStudlyCase('FooBar'))->toBeTrue();
});
