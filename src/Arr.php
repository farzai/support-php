<?php

namespace Farzai\Support;

use ArrayAccess;

class Arr
{
    /**
     * Get an item from an array using "dot" notation.
     *
     * @param  mixed  $array
     * @return mixed
     */
    public static function get($array, $key, $default = null)
    {
        if (is_null($key)) {
            return $array;
        }

        if (! static::accessible($array)) {
            return $default;
        }

        foreach (explode('.', $key) as $segment) {
            if (! static::exists($array, $segment)) {
                return $default;
            }

            if (static::accessible($array[$segment])) {
                $array = $array[$segment];
            } else {
                return $array[$segment];
            }
        }

        return $array;
    }

    /**
     * Determine if the given key exists in the provided array.
     */
    public static function exists($array, $key): bool
    {
        foreach (explode('.', $key) as $segment) {
            if (isset($array[$segment])) {
                $array = $array[$segment];
            } else {
                return false;
            }
        }

        return true;
    }

    /**
     * Determine if the given value is array accessible.
     */
    public static function accessible($value): bool
    {
        return is_array($value) || $value instanceof ArrayAccess;
    }
}
