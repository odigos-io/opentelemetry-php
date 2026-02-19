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

use Symfony\Component\Mailer\Exception\UnsupportedSchemeException;
/**
 * @author Konstantin Myakshin <molodchick@gmail.com>
 */
final class SendmailTransportFactory extends \Symfony\Component\Mailer\Transport\AbstractTransportFactory
{
    public function create(\Symfony\Component\Mailer\Transport\Dsn $dsn): \Symfony\Component\Mailer\Transport\TransportInterface
    {
        if ('sendmail+smtp' === $dsn->getScheme() || 'sendmail' === $dsn->getScheme()) {
            return new \Symfony\Component\Mailer\Transport\SendmailTransport($dsn->getOption('command'), $this->dispatcher, $this->logger);
        }
        throw new UnsupportedSchemeException($dsn, 'sendmail', $this->getSupportedSchemes());
    }
    protected function getSupportedSchemes(): array
    {
        return ['sendmail', 'sendmail+smtp'];
    }
}
