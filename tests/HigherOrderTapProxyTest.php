<?php

use Farzai\Support\HigherOrderTapProxy;

it('calls the method on the target', function () {
    $target = new class {
        public $called = false;

        public function foo()
        {
            $this->called = true;
        }
    };

    $proxy = new HigherOrderTapProxy($target);

    $proxy->foo();

    expect($target->called)->toBeTrue();
});