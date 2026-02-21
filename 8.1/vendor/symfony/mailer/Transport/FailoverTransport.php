<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Symfony\Component\Mailer\Transport;

/**
 * Uses several Transports using a failover algorithm.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class FailoverTransport extends \Symfony\Component\Mailer\Transport\RoundRobinTransport
{
    private ?\Symfony\Component\Mailer\Transport\TransportInterface $currentTransport = null;
    protected function getNextTransport(): ?\Symfony\Component\Mailer\Transport\TransportInterface
    {
        if (null === $this->currentTransport || $this->isTransportDead($this->currentTransport)) {
            $this->currentTransport = parent::getNextTransport();
        }
        return $this->currentTransport;
    }
    protected function getInitialCursor(): int
    {
        return 0;
    }
    protected function getNameSymbol(): string
    {
        return 'failover';
    }
}
