<?php

declare(strict_types=1);

namespace Farzai\Support;

/**
 * HigherOrderTapProxy allows method chaining on objects for side effects.
 *
 * This class is used by the tap() function to enable fluent method calls
 * on an object without returning the result of the method calls.
 *
 * @example
 * $user = tap($user)->update(['name' => 'John'])->save();
 * // Calls $user->update() and $user->save() but returns $user
 */
class HigherOrderTapProxy
{
    /**
     * The target object being tapped.
     *
     * @var object
     */
    protected object $target;

    /**
     * Create a new tap proxy instance.
     *
     * @param  object  $target  The object to tap into
     *
     * @example
     * new HigherOrderTapProxy($user);
     */
    public function __construct(object $target)
    {
        $this->target = $target;
    }

    /**
     * Dynamically pass method calls to the target and return the target.
     *
     * This enables fluent method chaining where you can call multiple methods
     * on an object for their side effects, but always return the original object.
     *
     * @param  string  $method  The method name to call on the target
     * @param  array<int, mixed>  $parameters  The parameters to pass to the method
     * @return object The original target object (not the method's return value)
     *
     * @example
     * $proxy = new HigherOrderTapProxy($user);
     * $proxy->update(['name' => 'John']); // Returns $user, not the update result
     */
    public function __call(string $method, array $parameters): object
    {
        $this->target->{$method}(...$parameters);

        return $this->target;
    }
}
