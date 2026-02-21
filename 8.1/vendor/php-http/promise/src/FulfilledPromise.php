<?php

namespace Http\Promise;

/**
 * A promise already fulfilled.
 *
 * @author Joel Wurtz <joel.wurtz@gmail.com>
 */
final class FulfilledPromise implements \Http\Promise\Promise
{
    /**
     * @var mixed
     */
    private $result;
    /**
     * @param mixed $result
     */
    public function __construct($result)
    {
        $this->result = $result;
    }
    public function then(?callable $onFulfilled = null, ?callable $onRejected = null)
    {
        if (null === $onFulfilled) {
            return $this;
        }
        try {
            return new self($onFulfilled($this->result));
        } catch (\Exception $e) {
            return new \Http\Promise\RejectedPromise($e);
        }
    }
    public function getState()
    {
        return \Http\Promise\Promise::FULFILLED;
    }
    public function wait($unwrap = \true)
    {
        if ($unwrap) {
            return $this->result;
        }
        return null;
    }
}
