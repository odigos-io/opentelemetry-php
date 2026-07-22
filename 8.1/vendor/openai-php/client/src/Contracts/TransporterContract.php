<?php

declare (strict_types=1);
namespace Odigos\OpenAI\Contracts;

use Odigos\OpenAI\Exceptions\ErrorException;
use Odigos\OpenAI\Exceptions\TransporterException;
use Odigos\OpenAI\Exceptions\UnserializableResponse;
use Odigos\OpenAI\ValueObjects\Transporter\Payload;
use Odigos\OpenAI\ValueObjects\Transporter\Response;
use Psr\Http\Message\ResponseInterface;
/**
 * @internal
 */
interface TransporterContract
{
    /**
     * Sends a request to a server.
     *
     * @return Response<array<array-key, mixed>|string>
     *
     * @throws ErrorException|UnserializableResponse|TransporterException
     */
    public function requestObject(Payload $payload): Response;
    /**
     * Sends a content request to a server.
     *
     * @throws ErrorException|TransporterException
     */
    public function requestContent(Payload $payload): string;
    /**
     * Sends a stream request to a server.
     **
     * @throws ErrorException
     */
    public function requestStream(Payload $payload): ResponseInterface;
}
