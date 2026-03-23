<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Symfony\Component\Process\Exception;

use Symfony\Component\Process\Process;
/**
 * Exception for processes failed during startup.
 */
class ProcessStartFailedException extends \Symfony\Component\Process\Exception\ProcessFailedException
{
    public function __construct(private Process $process, ?string $message)
    {
        if ($process->isStarted()) {
            throw new \Symfony\Component\Process\Exception\InvalidArgumentException('Expected a process that failed during startup, but the given process was started successfully.');
        }
        $error = \sprintf('The command "%s" failed.' . "\n\nWorking directory: %s\n\nError: %s", $process->getCommandLine(), $process->getWorkingDirectory(), $message ?? 'unknown');
        // Skip parent constructor
        \Symfony\Component\Process\Exception\RuntimeException::__construct($error);
    }
    public function getProcess(): Process
    {
        return $this->process;
    }
}
