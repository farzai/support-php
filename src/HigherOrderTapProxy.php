<?php

namespace Farzai\Support;

class HigherOrderTapProxy
{
    /**
     * The target being tapped.
     *
     * @var mixed
     */
    protected $target;

    /**
     * Create a new tap proxy instance.
     *
     * @param  mixed  $target
     * @return void
     */
    public function __construct($target)
    {
        $this->target = $target;
    }

    /**
     * Dynamically pass method calls to the target.
     *
     * @param  callable  $callback
     * @return mixed
     */
    public function __invoke($callback)
    {
        return $callback($this->target);
    }
}
