<?php

use Farzai\Support\Arr;

it('can check if key exists in array', function () {
    $array = [
        'foo' => 'bar',
    ];

    $this->assertTrue(Arr::exists($array, 'foo'));
    $this->assertFalse(Arr::exists($array, 'bar'));
});

it('can check if key exists in array using dot notation', function () {
    $array = [
        'foo' => [
            'bar' => 'baz',
            'baz' => [
                'qux' => 'quux',
            ],
        ],
    ];

    $this->assertTrue(Arr::exists($array, 'foo.bar'));
    $this->assertFalse(Arr::exists($array, 'foo.qux'));
    $this->assertTrue(Arr::exists($array, 'foo.baz.qux'));
});

it('can get value from array', function () {
    $array = [
        'foo' => 'bar',
    ];

    $this->assertEquals('bar', Arr::get($array, 'foo'));
});

it('can get value from array using dot notation', function () {
    $array = [
        'foo' => [
            'bar' => 'baz',
        ],
    ];

    $this->assertEquals('baz', Arr::get($array, 'foo.bar'));
});

it('can get value from array using dot notation with default value', function () {
    $array = [
        'foo' => [
            'bar' => 'baz',
        ],
    ];

    $this->assertEquals('qux', Arr::get($array, 'foo.qux', 'qux'));
});

it('can get value from array using dot notation with null default value', function () {
    $array = [
        'foo' => [
            'bar' => 'baz',
        ],
    ];

    $this->assertNull(Arr::get($array, 'foo.qux'));
});
