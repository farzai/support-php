<?php

use function Farzai\Support\class_basename;
use function Farzai\Support\now;
use function Farzai\Support\tap;

it('can tap value', function () {
    $value = tap('foo', function ($value) {
        expect($value)->toBe('foo');
    });

    expect($value)->toBe('foo');
});

it('can get current date time', function () {
    $now = now();

    expect($now)->toBeInstanceOf(\DateTimeInterface::class);
});

it('can get class basename', function () {
    expect(class_basename('Farzai\Support\Str'))->toBe('Str');
});
