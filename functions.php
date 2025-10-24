<?php

declare(strict_types=1);

namespace Farzai\Support;

use DateTimeZone;

/**
 * Call the given Closure with the given value then return the value.
 *
 * This function allows you to "tap" into a method chain, perform some action,
 * and continue the chain. When called without a callback, it returns a
 * HigherOrderTapProxy for fluent method chaining.
 *
 * @param  mixed  $value  The value to tap into
 * @param  callable|null  $callback  Optional callback to execute with the value
 * @return mixed The original value or a HigherOrderTapProxy if no callback provided
 *
 * @example
 * // With callback
 * $user = tap($user, function ($u) {
 *     $u->update(['last_login' => now()]);
 * });
 *
 * @example
 * // Without callback (higher-order proxy)
 * $user = tap($user)->update(['last_login' => now()])->save();
 */
function tap(mixed $value, ?callable $callback = null): mixed
{
    if (is_null($callback)) {
        return is_object($value) ? new HigherOrderTapProxy($value) : $value;
    }

    $callback($value);

    return $value;
}

/**
 * Get the current date and time.
 *
 * Returns a Carbon instance representing the current date/time in the specified timezone.
 *
 * @param  \DateTimeZone|string|null  $timezone  Optional timezone (defaults to app timezone)
 * @return Carbon A Carbon instance representing now
 *
 * @example
 * now(); // Returns: Carbon instance of current time
 * now('America/New_York'); // Returns: Carbon instance in NY timezone
 * now()->addDays(5); // Returns: Carbon instance 5 days from now
 */
function now(DateTimeZone|string|null $timezone = null): Carbon
{
    return Carbon::now($timezone);
}

/**
 * Get the class "basename" of the given object or class.
 *
 * Returns the class name without the namespace.
 *
 * @param  object|string  $class  The object instance or fully-qualified class name
 * @return string The class basename (without namespace)
 *
 * @example
 * class_basename('App\Models\User'); // Returns: 'User'
 * class_basename(new \App\Models\User); // Returns: 'User'
 * class_basename('\Foo\Bar\Baz'); // Returns: 'Baz'
 */
function class_basename(object|string $class): string
{
    $class = is_object($class) ? get_class($class) : $class;

    return basename(str_replace('\\', '/', $class));
}
