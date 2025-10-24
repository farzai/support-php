<?php

declare(strict_types=1);

namespace Farzai\Support;

class Str
{
    /**
     * Convert a string to camelCase.
     *
     * @param  string  $value  The string to convert
     * @return string The camelCase formatted string
     *
     * @example
     * Str::camel('foo_bar'); // Returns: 'fooBar'
     * Str::camel('foo-bar'); // Returns: 'fooBar'
     */
    public static function camel(string $value): string
    {
        return lcfirst(static::studly($value));
    }

    /**
     * Convert a string to StudlyCase (PascalCase).
     *
     * @param  string  $value  The string to convert
     * @return string The StudlyCase formatted string
     *
     * @example
     * Str::studly('foo_bar'); // Returns: 'FooBar'
     * Str::studly('foo-bar'); // Returns: 'FooBar'
     */
    public static function studly(string $value): string
    {
        $value = ucwords(str_replace(['-', '_'], ' ', $value));

        return str_replace(' ', '', $value);
    }

    /**
     * Convert a string to snake_case.
     *
     * @param  string  $value  The string to convert
     * @param  string  $delimiter  The delimiter to use (default: '_')
     * @return string The snake_case formatted string
     *
     * @example
     * Str::snake('fooBar'); // Returns: 'foo_bar'
     * Str::snake('FooBar', '-'); // Returns: 'foo-bar'
     */
    public static function snake(string $value, string $delimiter = '_'): string
    {
        // Check if the given value is already in snake case.
        if (!ctype_lower($value)) {
            $value = preg_replace('/\s+/u', '', ucwords($value)) ?? $value;

            $value = static::lower(preg_replace('/(.)(?=[A-Z])/u', '$1' . $delimiter, $value) ?? $value);
        }

        return $value;
    }

    /**
     * Convert a string to lowercase using multi-byte safe function.
     *
     * @param  string  $value  The string to convert
     * @return string The lowercase string
     *
     * @example
     * Str::lower('FOO BAR'); // Returns: 'foo bar'
     * Str::lower('ÑOÑO'); // Returns: 'ñoño' (UTF-8 safe)
     */
    public static function lower(string $value): string
    {
        return mb_strtolower($value, 'UTF-8');
    }

    /**
     * Replace all occurrences of the search string with the replacement string.
     *
     * @param  string|array<int, string>  $search  The value(s) to search for
     * @param  string|array<int, string>  $replace  The replacement value(s)
     * @param  string  $subject  The string to search in
     * @return string The string with replacements made
     *
     * @example
     * Str::replace('foo', 'bar', 'foo baz'); // Returns: 'bar baz'
     */
    public static function replace(string|array $search, string|array $replace, string $subject): string
    {
        return str_replace($search, $replace, $subject);
    }

    /**
     * Determine if a string starts with a given substring or any of the given substrings.
     *
     * @param  string  $haystack  The string to search in
     * @param  string|array<int, string>  $needles  The substring(s) to look for
     * @return bool True if the string starts with any of the needles
     *
     * @example
     * Str::startsWith('foobar', 'foo'); // Returns: true
     * Str::startsWith('foobar', ['bar', 'foo']); // Returns: true
     */
    public static function startsWith(string $haystack, string|array $needles): bool
    {
        foreach ((array) $needles as $needle) {
            if ($needle !== '' && str_starts_with($haystack, $needle)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine if a string ends with a given substring or any of the given substrings.
     *
     * @param  string  $haystack  The string to search in
     * @param  string|array<int, string>  $needles  The substring(s) to look for
     * @return bool True if the string ends with any of the needles
     *
     * @example
     * Str::endsWith('foobar', 'bar'); // Returns: true
     * Str::endsWith('foobar', ['foo', 'bar']); // Returns: true
     */
    public static function endsWith(string $haystack, string|array $needles): bool
    {
        foreach ((array) $needles as $needle) {
            if ($needle !== '' && str_ends_with($haystack, $needle)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get the length of a string using multi-byte safe function.
     *
     * @param  string  $value  The string to measure
     * @return int The length of the string
     *
     * @example
     * Str::length('foo'); // Returns: 3
     * Str::length('ñoño'); // Returns: 4 (UTF-8 safe)
     */
    public static function length(string $value): int
    {
        return mb_strlen($value);
    }

    /**
     * Extract a substring from a string using multi-byte safe function.
     *
     * @param  string  $string  The input string
     * @param  int  $start  The start position
     * @param  int|null  $length  The length to extract (null for rest of string)
     * @return string The extracted substring
     *
     * @example
     * Str::substr('foobar', 0, 3); // Returns: 'foo'
     * Str::substr('foobar', 3); // Returns: 'bar'
     */
    public static function substr(string $string, int $start, ?int $length = null): string
    {
        return mb_substr($string, $start, $length, 'UTF-8');
    }

    /**
     * Determine if a string contains a given substring or any of the given substrings.
     *
     * @param  string  $haystack  The string to search in
     * @param  string|array<int, string>  $needles  The substring(s) to look for
     * @return bool True if the string contains any of the needles
     *
     * @example
     * Str::contains('foobar', 'bar'); // Returns: true
     * Str::contains('foobar', ['baz', 'bar']); // Returns: true
     */
    public static function contains(string $haystack, string|array $needles): bool
    {
        foreach ((array) $needles as $needle) {
            if ($needle !== '' && str_contains($haystack, $needle)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine if a string is in snake_case format.
     *
     * @param  string  $value  The string to check
     * @return bool True if the string is in snake_case
     *
     * @example
     * Str::isSnakeCase('foo_bar'); // Returns: true
     * Str::isSnakeCase('fooBar'); // Returns: false
     */
    public static function isSnakeCase(string $value): bool
    {
        return $value === static::snake($value);
    }

    /**
     * Determine if a string is in camelCase format.
     *
     * @param  string  $value  The string to check
     * @return bool True if the string is in camelCase
     *
     * @example
     * Str::isCamelCase('fooBar'); // Returns: true
     * Str::isCamelCase('foo_bar'); // Returns: false
     */
    public static function isCamelCase(string $value): bool
    {
        return $value === static::camel($value);
    }

    /**
     * Determine if a string is in StudlyCase format.
     *
     * @param  string  $value  The string to check
     * @return bool True if the string is in StudlyCase
     *
     * @example
     * Str::isStudlyCase('FooBar'); // Returns: true
     * Str::isStudlyCase('foo_bar'); // Returns: false
     */
    public static function isStudlyCase(string $value): bool
    {
        return $value === static::studly($value);
    }

    /**
     * Generate a cryptographically secure random alpha-numeric string.
     *
     * This method uses base64 encoding of random bytes, removing URL-unsafe characters.
     * For more control over character sets, use randomString() instead.
     *
     * @param  int  $length  The desired length of the random string
     * @return string A random string of the specified length
     *
     * @throws \Exception If random_bytes() fails
     *
     * @example
     * Str::random(16); // Returns: 'a3K7mN9pQ1xY2zB5'
     */
    public static function random(int $length = 16): string
    {
        $string = '';

        while (static::length($string) < $length) {
            $remaining = $length - static::length($string);
            $bytes = random_bytes(max(1, $remaining));
            $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $remaining);
        }

        return $string;
    }

    /**
     * Generate a cryptographically secure random ASCII string.
     *
     * @param  int  $length  The desired length of the random string
     * @return string A random ASCII string of the specified length
     *
     * @throws \Exception If random_bytes() fails
     *
     * @example
     * Str::randomAscii(16); // Returns: 'a3K7mN9pQ1xY2zB5'
     */
    public static function randomAscii(int $length = 16): string
    {
        return static::substr(str_replace(['/', '+', '='], '', base64_encode(random_bytes(max(1, $length)))), 0, $length);
    }

    /**
     * Generate a cryptographically secure random numeric string.
     *
     * @param  int  $length  The desired length of the random string
     * @return string A random numeric string of the specified length
     *
     * @throws \Exception If random_int() fails
     *
     * @example
     * Str::randomNumeric(6); // Returns: '472891'
     */
    public static function randomNumeric(int $length = 16): string
    {
        $string = '';

        while (static::length($string) < $length) {
            $string .= (string) random_int(0, 9);
        }

        return $string;
    }

    /**
     * Generate a cryptographically secure random alphanumeric string.
     *
     * This method generates a string containing only letters (A-Z, a-z) and numbers (0-9).
     *
     * @param  int  $length  The desired length of the random string
     * @return string A random alphanumeric string of the specified length
     *
     * @throws \Exception If random_int() fails
     *
     * @example
     * Str::randomAlphanumeric(12); // Returns: 'aB3xY9mK2nP7'
     */
    public static function randomAlphanumeric(int $length = 16): string
    {
        return static::randomString($length, 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789');
    }

    /**
     * Generate a cryptographically secure random string from a custom character set.
     *
     * @param  int  $length  The desired length of the random string
     * @param  string|null  $characters  The character set to use (defaults to alphanumeric)
     * @return string A random string of the specified length from the character set
     *
     * @throws \Exception If random_int() fails
     *
     * @example
     * Str::randomString(8, 'ABCD123'); // Returns: 'A2B1C3D2'
     * Str::randomString(10); // Returns: 'aB3xY9mK2n' (default alphanumeric)
     */
    public static function randomString(int $length = 16, ?string $characters = null): string
    {
        $characters = $characters ?? 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $max = static::length($characters) - 1;
        $string = '';

        for ($i = 0; $i < $length; $i++) {
            $string .= $characters[random_int(0, $max)];
        }

        return $string;
    }

    /**
     * Generate a cryptographically secure random alphanumeric string (alias for randomAlphanumeric).
     *
     * @param  int  $length  The desired length of the random string
     * @return string A random alphanumeric string of the specified length
     *
     * @throws \Exception If random_int() fails
     *
     * @example
     * Str::randomStringWithNumeric(10); // Returns: 'aB3xY9mK2n'
     */
    public static function randomStringWithNumeric(int $length = 16): string
    {
        return static::randomAlphanumeric($length);
    }

    /**
     * Generate a cryptographically secure random string with special characters.
     *
     * This method generates a string containing letters, numbers, and special characters.
     * Useful for generating secure passwords.
     *
     * @param  int  $length  The desired length of the random string
     * @return string A random string with special characters
     *
     * @throws \Exception If random_int() fails
     *
     * @example
     * Str::randomStringWithSpecialCharacter(12); // Returns: 'aB3!xY@9#mK2'
     */
    public static function randomStringWithSpecialCharacter(int $length = 16): string
    {
        return static::randomString($length, 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_+-=[]{};:,.<>/?');
    }
}
