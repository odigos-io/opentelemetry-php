<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Odigos\Symfony\Component\Mailer\Transport;

use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;
use Odigos\Symfony\Component\HttpClient\HttpClient;
use Odigos\Symfony\Component\Mailer\Exception\HttpTransportException;
use Odigos\Symfony\Component\Mailer\SentMessage;
use Odigos\Symfony\Contracts\HttpClient\HttpClientInterface;
use Odigos\Symfony\Contracts\HttpClient\ResponseInterface;
/**
 * @author Victor Bocharsky <victor@symfonycasts.com>
 */
abstract class AbstractHttpTransport extends AbstractTransport
{
    protected ?string $host = null;
    protected ?int $port = null;
    public function __construct(protected ?HttpClientInterface $client = null, ?EventDispatcherInterface $dispatcher = null, ?LoggerInterface $logger = null)
    {
        if (null === $client) {
            if (!class_exists(HttpClient::class)) {
                throw new \LogicException(\sprintf('You cannot use "%s" as the HttpClient component is not installed. Try running "composer require symfony/http-client".', __CLASS__));
            }
            $this->client = HttpClient::create();
        }
        parent::__construct($dispatcher, $logger);
    }
    /**
     * @return $this
     */
    public function setHost(?string $host): static
    {
        $this->host = $host;
        return $this;
    }
    /**
     * @return $this
     */
    public function setPort(?int $port): static
    {
        $this->port = $port;
        return $this;
    }
    abstract protected function doSendHttp(SentMessage $message): ResponseInterface;
    protected function doSend(SentMessage $message): void
    {
        try {
            $response = $this->doSendHttp($message);
            $message->appendDebug($response->getInfo('debug') ?? '');
        } catch (HttpTransportException $e) {
            $e->appendDebug($e->getResponse()->getInfo('debug') ?? '');
            throw $e;
        }
    }
}
