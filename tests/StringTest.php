<?php

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
