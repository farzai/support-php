<?php

use Farzai\Support\Str;

it('can convert string to camel case', function () {
    $this->assertEquals('fooBar', Str::camel('FooBar'));
    $this->assertEquals('fooBar', Str::camel('foo_bar'));
});

it('can convert string to studly case', function () {
    $this->assertEquals('FooBar', Str::studly('fooBar'));
    $this->assertEquals('FooBar', Str::studly('foo_bar'));
});

it('can convert string to snake case', function () {
    $this->assertEquals('foo_bar', Str::snake('fooBar'));
    $this->assertEquals('foo_bar', Str::snake('fooBar', '_'));
});

it('can convert string to lower case', function () {
    $this->assertEquals('foo bar baz', Str::lower('FOO BAR BAZ'));
});

it('can replace string', function () {
    $this->assertEquals('bar bar baz', Str::replace('foo', 'bar', 'foo bar baz'));
});
