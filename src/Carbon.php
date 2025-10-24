<?php

declare(strict_types=1);

namespace Farzai\Support;

use Carbon\Carbon as BaseCarbon;
use DateTimeInterface;
use DateTimeZone;

/**
 * Enhanced Carbon date/time class with additional convenience methods.
 *
 * This extends the popular Carbon library with additional helper methods
 * commonly used in applications.
 */
class Carbon extends BaseCarbon
{
    /**
     * Create a Carbon instance from a Unix timestamp.
     *
     * @param  int  $timestamp  Unix timestamp
     * @param  \DateTimeZone|string|null  $tz  Optional timezone
     * @return static A new Carbon instance
     *
     * @example
     * Carbon::fromTimestamp(1609459200); // Creates instance from timestamp
     */
    public static function fromTimestamp(int $timestamp, DateTimeZone|string|null $tz = null): static
    {
        return static::createFromTimestamp($timestamp, $tz);
    }

    /**
     * Check if the date is today.
     *
     * @return bool True if the date is today
     *
     * @example
     * Carbon::now()->isToday(); // Returns: true
     * Carbon::yesterday()->isToday(); // Returns: false
     */
    public function isToday(): bool
    {
        return $this->isCurrentDay();
    }

    /**
     * Check if the date is in the past (before now).
     *
     * @return bool True if the date is in the past
     *
     * @example
     * Carbon::yesterday()->isPast(); // Returns: true
     * Carbon::tomorrow()->isPast(); // Returns: false
     */
    public function isPast(): bool
    {
        return $this->lt(static::now());
    }

    /**
     * Check if the date is in the future (after now).
     *
     * @return bool True if the date is in the future
     *
     * @example
     * Carbon::tomorrow()->isFuture(); // Returns: true
     * Carbon::yesterday()->isFuture(); // Returns: false
     */
    public function isFuture(): bool
    {
        return $this->gt(static::now());
    }

    /**
     * Check if this date is between two other dates (inclusive).
     *
     * @param  \DateTimeInterface  $start  The start date
     * @param  \DateTimeInterface  $end  The end date
     * @return bool True if between the dates (inclusive)
     *
     * @example
     * Carbon::now()->isBetweenDates(Carbon::yesterday(), Carbon::tomorrow()); // Returns: true
     */
    public function isBetweenDates(DateTimeInterface $start, DateTimeInterface $end): bool
    {
        return $this->between($start, $end, true);
    }

    /**
     * Get the difference in days (absolute value).
     *
     * @param  \DateTimeInterface|null  $date  The date to compare with (defaults to now)
     * @return int The number of days difference
     *
     * @example
     * Carbon::now()->diffInDaysAbsolute(Carbon::yesterday()); // Returns: 1
     */
    public function diffInDaysAbsolute(?DateTimeInterface $date = null): int
    {
        return (int) abs($this->diffInDays($date ?? static::now()));
    }
}
