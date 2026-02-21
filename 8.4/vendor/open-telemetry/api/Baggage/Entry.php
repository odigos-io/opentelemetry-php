<?php

declare (strict_types=1);
namespace OpenTelemetry\API\Baggage;

final class Entry
{
    public function __construct(private readonly mixed $value, private readonly \OpenTelemetry\API\Baggage\MetadataInterface $metadata)
    {
    }
    public function getValue(): mixed
    {
        return $this->value;
    }
    public function getMetadata(): \OpenTelemetry\API\Baggage\MetadataInterface
    {
        return $this->metadata;
    }
}
