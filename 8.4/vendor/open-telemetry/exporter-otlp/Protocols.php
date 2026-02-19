<?php

declare (strict_types=1);
namespace OpenTelemetry\Contrib\Otlp;

use OpenTelemetry\SDK\Common\Configuration\KnownValues;
use UnexpectedValueException;
class Protocols
{
    public const GRPC = KnownValues::VALUE_GRPC;
    public const HTTP_PROTOBUF = KnownValues::VALUE_HTTP_PROTOBUF;
    public const HTTP_JSON = KnownValues::VALUE_HTTP_JSON;
    public const HTTP_NDJSON = KnownValues::VALUE_HTTP_NDJSON;
    private const PROTOCOLS = [self::GRPC => \OpenTelemetry\Contrib\Otlp\ContentTypes::PROTOBUF, self::HTTP_PROTOBUF => \OpenTelemetry\Contrib\Otlp\ContentTypes::PROTOBUF, self::HTTP_JSON => \OpenTelemetry\Contrib\Otlp\ContentTypes::JSON, self::HTTP_NDJSON => \OpenTelemetry\Contrib\Otlp\ContentTypes::NDJSON];
    public static function validate(string $protocol): void
    {
        if (!array_key_exists($protocol, self::PROTOCOLS)) {
            throw new UnexpectedValueException('Unknown protocol: ' . $protocol);
        }
    }
    /**
     * @psalm-return ContentTypes::*
     */
    public static function contentType(string $protocol): string
    {
        self::validate($protocol);
        return self::PROTOCOLS[$protocol];
    }
}
