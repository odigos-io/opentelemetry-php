<?php

namespace Odigos\Illuminate\Console\Events;

use Odigos\Symfony\Component\Console\Input\InputInterface;
use Odigos\Symfony\Component\Console\Output\OutputInterface;
class CommandFinished
{
    /**
     * Create a new event instance.
     *
     * @param  string  $command  The command name.
     * @param  \Symfony\Component\Console\Input\InputInterface  $input  The console input implementation.
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output  The command output implementation.
     * @param  int  $exitCode  The command exit code.
     */
    public function __construct(public string $command, public InputInterface $input, public OutputInterface $output, public int $exitCode)
    {
    }
}
