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

        $keyString = (string) $key;

        // Handle simple keys (no dots) directly
        if (!str_contains($keyString, '.')) {
            if (is_array($array)) {
                return array_key_exists($keyString, $array) ? $array[$keyString] : $default;
            }

            // For ArrayAccess, use offsetExists to match array_key_exists behavior
            // This correctly handles null values (unlike isset which returns false for null)
            return $array->offsetExists($keyString) ? $array[$keyString] : $default;
        }

        // Handle dot notation
        foreach (explode('.', $keyString) as $segment) {
            if (!static::accessible($array)) {
                return $default;
            }

            if (is_array($array)) {
                if (!array_key_exists($segment, $array)) {
                    return $default;
                }
            } else {
                // For ArrayAccess, use offsetExists instead of iterator_to_array
                // This is much more efficient and avoids converting the entire object to an array
                if (!$array->offsetExists($segment)) {
                    return $default;
                }
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
        if (!static::accessible($array)) {
            return false;
        }

        $keyString = (string) $key;

        // Handle simple keys (no dots) directly
        if (!str_contains($keyString, '.')) {
            if (is_array($array)) {
                return array_key_exists($keyString, $array);
            }

            // For ArrayAccess, use offsetExists
            return $array->offsetExists($keyString);
        }

        // Handle dot notation
        foreach (explode('.', $keyString) as $segment) {
            if (!static::accessible($array)) {
                return false;
            }

            if (is_array($array)) {
                if (!array_key_exists($segment, $array)) {
                    return false;
                }
            } else {
                // For ArrayAccess, use offsetExists instead of iterator_to_array
                if (!$array->offsetExists($segment)) {
                    return false;
                }
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
