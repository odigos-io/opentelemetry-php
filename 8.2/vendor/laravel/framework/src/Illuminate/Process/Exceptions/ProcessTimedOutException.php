<?php

namespace Odigos\Illuminate\Process\Exceptions;

use Odigos\Illuminate\Contracts\Process\ProcessResult;
use Odigos\Symfony\Component\Process\Exception\ProcessTimedOutException as SymfonyTimeoutException;
use Odigos\Symfony\Component\Process\Exception\RuntimeException;
class ProcessTimedOutException extends RuntimeException
{
    /**
     * The process result instance.
     *
     * @var \Illuminate\Contracts\Process\ProcessResult
     */
    public $result;
    /**
     * Create a new exception instance.
     *
     * @param  \Symfony\Component\Process\Exception\ProcessTimedOutException  $original
     * @param  \Illuminate\Contracts\Process\ProcessResult  $result
     */
    public function __construct(SymfonyTimeoutException $original, ProcessResult $result)
    {
        $this->result = $result;
        parent::__construct($original->getMessage(), $original->getCode(), $original);
    }
}
