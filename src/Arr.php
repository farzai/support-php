<?php

declare(strict_types=1);

namespace Farzai\Support;

use ArrayAccess;

class Arr
{
    /**
     * Get an item from an array using "dot" notation.
     *
     * @param  array<array-key, mixed>|ArrayAccess<array-key, mixed>  $array  The array to search
     * @param  string|int|null  $key  The key to retrieve using dot notation (e.g., 'foo.bar.baz')
     * @param  mixed  $default  The default value to return if the key doesn't exist
     * @return mixed The value at the given key or the default value
     *
     * @example
     * Arr::get(['foo' => ['bar' => 'baz']], 'foo.bar'); // Returns: 'baz'
     * Arr::get(['foo' => 'bar'], 'baz', 'default'); // Returns: 'default'
     */
    public static function get(array|ArrayAccess $array, string|int|null $key, mixed $default = null): mixed
    {
        if (is_null($key)) {
            return $array;
        }

        if (!static::accessible($array)) {
            return $default;
        }

        foreach (explode('.', (string) $key) as $segment) {
            if (!static::accessible($array)) {
                return $default;
            }

            if (!array_key_exists($segment, is_array($array) ? $array : iterator_to_array($array))) {
                return $default;
            }

            $array = $array[$segment];
        }

        return $array;
    }

    /**
     * Determine if the given key exists in the provided array using "dot" notation.
     *
     * @param  array<array-key, mixed>|ArrayAccess<array-key, mixed>  $array  The array to check
     * @param  string|int  $key  The key to check using dot notation (e.g., 'foo.bar.baz')
     * @return bool True if the key exists, false otherwise
     *
     * @example
     * Arr::exists(['foo' => ['bar' => 'baz']], 'foo.bar'); // Returns: true
     * Arr::exists(['foo' => 'bar'], 'foo.baz'); // Returns: false
     */
    public static function exists(array|ArrayAccess $array, string|int $key): bool
    {
        foreach (explode('.', (string) $key) as $segment) {
            if (!static::accessible($array)) {
                return false;
            }

            if (!array_key_exists($segment, is_array($array) ? $array : iterator_to_array($array))) {
                return false;
            }

            $array = $array[$segment];
        }

        return true;
    }

    /**
     * Determine if the given value is array accessible.
     *
     * @param  mixed  $value  The value to check
     * @return bool True if the value is an array or implements ArrayAccess
     *
     * @example
     * Arr::accessible(['foo' => 'bar']); // Returns: true
     * Arr::accessible(new ArrayObject(['foo' => 'bar'])); // Returns: true
     * Arr::accessible('string'); // Returns: false
     */
    public static function accessible(mixed $value): bool
    {
        return is_array($value) || $value instanceof ArrayAccess;
    }
}
