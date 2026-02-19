<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Symfony\Component\Console\Output;

/**
 * ConsoleOutputInterface is the interface implemented by ConsoleOutput class.
 * This adds information about stderr and section output stream.
 *
 * @author Dariusz Górecki <darek.krk@gmail.com>
 */
interface ConsoleOutputInterface extends \Symfony\Component\Console\Output\OutputInterface
{
    /**
     * Gets the OutputInterface for errors.
     */
    public function getErrorOutput(): \Symfony\Component\Console\Output\OutputInterface;
    public function setErrorOutput(\Symfony\Component\Console\Output\OutputInterface $error): void;
    public function section(): \Symfony\Component\Console\Output\ConsoleSectionOutput;
}
