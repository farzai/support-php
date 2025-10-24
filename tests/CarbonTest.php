<?php

declare(strict_types=1);

use Farzai\Support\Carbon;

it('can create instance from timestamp', function () {
    $timestamp = 1609459200; // 2021-01-01 00:00:00 UTC
    $carbon = Carbon::fromTimestamp($timestamp, 'UTC');

    expect($carbon)->toBeInstanceOf(Carbon::class);
    expect($carbon->timestamp)->toBe($timestamp);
});

it('can check if date is today', function () {
    expect(Carbon::now()->isToday())->toBeTrue();
    expect(Carbon::yesterday()->isToday())->toBeFalse();
    expect(Carbon::tomorrow()->isToday())->toBeFalse();
});

it('can check if date is in the past', function () {
    expect(Carbon::yesterday()->isPast())->toBeTrue();
    expect(Carbon::now()->subHour()->isPast())->toBeTrue();
    expect(Carbon::tomorrow()->isPast())->toBeFalse();
    expect(Carbon::now()->addHour()->isPast())->toBeFalse();
});

it('can check if date is in the future', function () {
    expect(Carbon::tomorrow()->isFuture())->toBeTrue();
    expect(Carbon::now()->addHour()->isFuture())->toBeTrue();
    expect(Carbon::yesterday()->isFuture())->toBeFalse();
    expect(Carbon::now()->subHour()->isFuture())->toBeFalse();
});

it('can check if date is between dates', function () {
    $today = Carbon::now();
    $yesterday = Carbon::yesterday();
    $tomorrow = Carbon::tomorrow();

    expect($today->isBetweenDates($yesterday, $tomorrow))->toBeTrue();
    expect($yesterday->isBetweenDates($today, $tomorrow))->toBeFalse();
    expect($tomorrow->isBetweenDates($yesterday, $today))->toBeFalse();
});

it('can get absolute difference in days', function () {
    $date1 = Carbon::create(2024, 1, 1, 12, 0, 0);
    $date2 = Carbon::create(2024, 1, 2, 12, 0, 0);
    $date3 = Carbon::create(2024, 1, 3, 12, 0, 0);

    expect($date1->diffInDaysAbsolute($date2))->toBe(1);
    expect($date2->diffInDaysAbsolute($date3))->toBe(1);
    expect($date1->diffInDaysAbsolute($date3))->toBe(2);
});

it('handles timezone conversions', function () {
    $utc = Carbon::create(2024, 3, 18, 12, 0, 0, 'UTC');
    $ny = Carbon::create(2024, 3, 18, 12, 0, 0, 'America/New_York');

    expect($utc->timestamp)->not->toBe($ny->timestamp);
});
