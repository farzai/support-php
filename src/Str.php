<?php

namespace Farzai\Support;

class Str
{
    public static function camel($value)
    {
        return lcfirst(static::studly($value));
    }

    public static function studly($value)
    {
        $value = ucwords(str_replace(['-', '_'], ' ', $value));

        return str_replace(' ', '', $value);
    }

    public static function snake($value, $delimiter = '_')
    {
        // Check if the given value is already in snake case.
        if (! ctype_lower($value)) {
            $value = preg_replace('/\s+/u', '', ucwords($value));

            $value = static::lower(preg_replace('/(.)(?=[A-Z])/u', '$1'.$delimiter, $value));
        }

        return $value;
    }

    public static function lower($value)
    {
        return mb_strtolower($value, 'UTF-8');
    }

    public static function replace($search, $replace, $subject)
    {
        return str_replace($search, $replace, $subject);
    }

    public static function startsWith($haystack, $needles)
    {
        foreach ((array) $needles as $needle) {
            if ($needle !== '' && strncmp($haystack, $needle, strlen($needle)) === 0) {
                return true;
            }
        }

        return false;
    }

    public static function endsWith($haystack, $needles)
    {
        foreach ((array) $needles as $needle) {
            if ((string) $needle === static::substr($haystack, -static::length($needle))) {
                return true;
            }
        }

        return false;
    }

    public static function length($value)
    {
        return mb_strlen($value);
    }

    public static function substr($string, $start, $length = null)
    {
        return mb_substr($string, $start, $length, 'UTF-8');
    }

    public static function contains($haystack, $needles)
    {
        foreach ((array) $needles as $needle) {
            if ($needle !== '' && mb_strpos($haystack, $needle) !== false) {
                return true;
            }
        }

        return false;
    }

    public static function isSnakeCase($value)
    {
        return $value === static::snake($value);
    }

    public static function isCamelCase($value)
    {
        return $value === static::camel($value);
    }

    public static function isStudlyCase($value)
    {
        return $value === static::studly($value);
    }

    /**
     * Generate a more truly "random" alpha-numeric string.
     *
     * @param  int  $length
     * @return string
     *
     * @throws \Exception
     */
    public static function random($length = 16)
    {
        $string = '';

        while (($len = static::length($string)) < $length) {
            $size = $length - $len;

            $bytes = random_bytes($size);

            $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
        }

        return $string;
    }

    /**
     * Generate a more truly "random" alpha-numeric string of ASCII characters.
     *
     * @param  int  $length
     * @return string
     *
     * @throws \Exception
     */
    public static function randomAscii($length = 16)
    {
        return static::substr(str_replace(['/', '+', '='], '', base64_encode(random_bytes($length))), 0, $length);
    }

    /**
     * Generate a more truly "random" numeric string.
     *
     * @param  int  $length
     * @return string
     *
     * @throws \Exception
     */
    public static function randomNumeric($length = 16)
    {
        $string = '';

        while (($len = static::length($string)) < $length) {
            $size = $length - $len;

            $bytes = random_bytes($size);

            $string .= preg_replace('/[^0-9]/', '', base64_encode($bytes));
        }

        return static::substr($string, 0, $length);
    }

    /**
     * Generate a more truly "random" alpha-numeric string.
     *
     * @param  int  $length
     * @return string
     *
     * @throws \Exception
     */
    public static function randomAlphanumeric($length = 16)
    {
        $string = '';

        while (($len = static::length($string)) < $length) {
            $size = $length - $len;

            $bytes = random_bytes($size);

            $string .= preg_replace('/[^A-Za-z0-9]/', '', base64_encode($bytes));
        }

        return static::substr($string, 0, $length);
    }

    /**
     * Generate a more truly "random" string.
     *
     * @param  int  $length
     * @param  string|null  $characters
     * @return string
     *
     * @throws \Exception
     */
    public static function randomString($length = 16, $characters = null)
    {
        $string = '';

        $characters = $characters ?: 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

        $max = static::length($characters) - 1;

        while (($len = static::length($string)) < $length) {
            $string .= $characters[random_int(0, $max)];
        }

        return $string;
    }

    public static function randomStringWithNumeric($length = 16)
    {
        return static::randomString($length, 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789');
    }

    public static function randomStringWithSpecialCharacter($length = 16)
    {
        return static::randomString($length, 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_+-=[]{};:,.<>/?');
    }
}
