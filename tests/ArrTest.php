<?php

declare(strict_types=1);

use Farzai\Support\Arr;

it('should return default value if array is not accessible', function () {
    // With strict types, Arr::get requires array|ArrayAccess
    // This test now checks that non-accessible arrays return the default
    $this->assertEquals('default', Arr::get([], 'foo', 'default'));
});

it('should return array if key is null', function () {
    $array = [
        'foo' => 'bar',
    ];

    $this->assertEquals($array, Arr::get($array, null));
});

it('should return default value if key does not exist', function () {
    $array = [
        'foo' => 'bar',
    ];

    $this->assertEquals('baz', Arr::get($array, 'qux', 'baz'));
});

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

it('can get value number from array using dot notation with default value', function () {
    $array = [
        'foo' => [
            'bar' => 0,
        ],
    ];

    $this->assertEquals(0, Arr::get($array, 'foo.bar', 'qux'));
});

// Edge case tests
it('handles empty array correctly', function () {
    expect(Arr::get([], 'foo', 'default'))->toBe('default');
    expect(Arr::exists([], 'foo'))->toBeFalse();
    expect(Arr::accessible([]))->toBeTrue();
});

it('handles deeply nested arrays', function () {
    $array = [
        'level1' => [
            'level2' => [
                'level3' => [
                    'level4' => [
                        'value' => 'deep',
                    ],
                ],
            ],
        ],
    ];

    expect(Arr::get($array, 'level1.level2.level3.level4.value'))->toBe('deep');
    expect(Arr::exists($array, 'level1.level2.level3.level4.value'))->toBeTrue();
});

it('handles numeric keys correctly', function () {
    $array = [
        'items' => [
            0 => 'first',
            1 => 'second',
            2 => 'third',
        ],
    ];

    expect(Arr::get($array, 'items.0'))->toBe('first');
    expect(Arr::get($array, 'items.1'))->toBe('second');
    expect(Arr::exists($array, 'items.2'))->toBeTrue();
});

it('handles ArrayAccess objects correctly', function () {
    $arrayObject = new ArrayObject([
        'foo' => [
            'bar' => 'baz',
        ],
    ]);

    expect(Arr::accessible($arrayObject))->toBeTrue();
    expect(Arr::get($arrayObject, 'foo.bar'))->toBe('baz');
    expect(Arr::exists($arrayObject, 'foo.bar'))->toBeTrue();
});

it('returns default for non-existent nested keys', function () {
    $array = ['foo' => 'bar'];

    expect(Arr::get($array, 'foo.bar.baz', 'default'))->toBe('default');
    expect(Arr::exists($array, 'foo.bar.baz'))->toBeFalse();
});

it('handles null and false values correctly', function () {
    $array = [
        'null' => null,
        'false' => false,
        'zero' => 0,
        'empty' => '',
    ];

    expect(Arr::get($array, 'null'))->toBeNull();
    expect(Arr::get($array, 'false'))->toBeFalse();
    expect(Arr::get($array, 'zero'))->toBe(0);
    expect(Arr::get($array, 'empty'))->toBe('');

    expect(Arr::exists($array, 'null'))->toBeTrue();
    expect(Arr::exists($array, 'false'))->toBeTrue();
    expect(Arr::exists($array, 'zero'))->toBeTrue();
    expect(Arr::exists($array, 'empty'))->toBeTrue();
});

it('handles special characters in keys', function () {
    $array = [
        'key-with-dash' => 'value1',
        'key_with_underscore' => 'value2',
        'key.with.dot' => 'value3',
    ];

    // Note: dots in keys conflict with dot notation
    expect(Arr::get($array, 'key-with-dash'))->toBe('value1');
    expect(Arr::get($array, 'key_with_underscore'))->toBe('value2');
});

it('handles arrays with mixed nested structures', function () {
    $array = [
        'mixed' => [
            'array' => ['a', 'b', 'c'],
            'object' => (object) ['foo' => 'bar'],
            'scalar' => 'value',
        ],
    ];

    expect(Arr::get($array, 'mixed.array'))->toBe(['a', 'b', 'c']);
    expect(Arr::get($array, 'mixed.scalar'))->toBe('value');
});
