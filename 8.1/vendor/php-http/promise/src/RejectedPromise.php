<?php

namespace Http\Promise;

/**
 * A rejected promise.
 *
 * @author Joel Wurtz <joel.wurtz@gmail.com>
 */
final class RejectedPromise implements \Http\Promise\Promise
{
    /**
     * @var \Throwable
     */
    private $exception;
    public function __construct(\Throwable $exception)
    {
        $this->exception = $exception;
    }
    public function then(?callable $onFulfilled = null, ?callable $onRejected = null)
    {
        if (null === $onRejected) {
            return $this;
        }
        try {
            return new \Http\Promise\FulfilledPromise($onRejected($this->exception));
        } catch (\Exception $e) {
            return new self($e);
        }
    }
    public function getState()
    {
        return \Http\Promise\Promise::REJECTED;
    }
    public function wait($unwrap = \true)
    {
        if ($unwrap) {
            throw $this->exception;
        }
        return null;
    }
}
