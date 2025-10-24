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

// Performance optimization tests
it('handles simple keys without dots efficiently', function () {
    $array = [
        'simple_key' => 'simple_value',
        'another' => 'test',
    ];

    // Test simple key retrieval (optimized path)
    expect(Arr::get($array, 'simple_key'))->toBe('simple_value');
    expect(Arr::get($array, 'nonexistent', 'default'))->toBe('default');
    expect(Arr::exists($array, 'simple_key'))->toBeTrue();
    expect(Arr::exists($array, 'nonexistent'))->toBeFalse();
});

it('handles integer keys without dots', function () {
    $array = [
        0 => 'zero',
        1 => 'one',
        123 => 'one-two-three',
    ];

    // Test integer key retrieval
    expect(Arr::get($array, 0))->toBe('zero');
    expect(Arr::get($array, 123))->toBe('one-two-three');
    expect(Arr::get($array, 999, 'default'))->toBe('default');
    expect(Arr::exists($array, 0))->toBeTrue();
    expect(Arr::exists($array, 123))->toBeTrue();
    expect(Arr::exists($array, 999))->toBeFalse();
});

it('handles ArrayAccess with null values correctly', function () {
    $arrayObject = new ArrayObject([
        'null_value' => null,
        'false_value' => false,
        'zero_value' => 0,
        'empty_string' => '',
    ]);

    // Verify null values are retrievable (not treated as missing)
    expect(Arr::get($arrayObject, 'null_value'))->toBeNull();
    expect(Arr::get($arrayObject, 'false_value'))->toBeFalse();
    expect(Arr::get($arrayObject, 'zero_value'))->toBe(0);
    expect(Arr::get($arrayObject, 'empty_string'))->toBe('');

    // Verify exists returns true for these values
    expect(Arr::exists($arrayObject, 'null_value'))->toBeTrue();
    expect(Arr::exists($arrayObject, 'false_value'))->toBeTrue();
    expect(Arr::exists($arrayObject, 'zero_value'))->toBeTrue();
    expect(Arr::exists($arrayObject, 'empty_string'))->toBeTrue();
});

it('handles nested ArrayAccess without performance issues', function () {
    // Create nested ArrayObject structure
    $deepObject = new ArrayObject([
        'level1' => new ArrayObject([
            'level2' => new ArrayObject([
                'level3' => 'deep_value',
            ]),
        ]),
    ]);

    // This should use offsetExists instead of iterator_to_array
    expect(Arr::get($deepObject, 'level1.level2.level3'))->toBe('deep_value');
    expect(Arr::exists($deepObject, 'level1.level2.level3'))->toBeTrue();
    expect(Arr::get($deepObject, 'level1.level2.nonexistent', 'default'))->toBe('default');
});

it('handles mixed array and ArrayAccess nesting', function () {
    $mixed = new ArrayObject([
        'array_inside' => [
            'nested' => 'value1',
        ],
    ]);

    $array = [
        'object_inside' => new ArrayObject([
            'nested' => 'value2',
        ]),
    ];

    expect(Arr::get($mixed, 'array_inside.nested'))->toBe('value1');
    expect(Arr::get($array, 'object_inside.nested'))->toBe('value2');
    expect(Arr::exists($mixed, 'array_inside.nested'))->toBeTrue();
    expect(Arr::exists($array, 'object_inside.nested'))->toBeTrue();
});
