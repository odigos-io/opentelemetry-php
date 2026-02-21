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

use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\Exception\IncompleteDsnException;
use Symfony\Contracts\HttpClient\HttpClientInterface;
/**
 * @author Konstantin Myakshin <molodchick@gmail.com>
 */
abstract class AbstractTransportFactory implements \Symfony\Component\Mailer\Transport\TransportFactoryInterface
{
    public function __construct(protected ?EventDispatcherInterface $dispatcher = null, protected ?HttpClientInterface $client = null, protected ?LoggerInterface $logger = null)
    {
    }
    public function supports(\Symfony\Component\Mailer\Transport\Dsn $dsn): bool
    {
        return \in_array($dsn->getScheme(), $this->getSupportedSchemes(), \true);
    }
    abstract protected function getSupportedSchemes(): array;
    protected function getUser(\Symfony\Component\Mailer\Transport\Dsn $dsn): string
    {
        return $dsn->getUser() ?? throw new IncompleteDsnException('User is not set.');
    }
    protected function getPassword(\Symfony\Component\Mailer\Transport\Dsn $dsn): string
    {
        return $dsn->getPassword() ?? throw new IncompleteDsnException('Password is not set.');
    }
}
