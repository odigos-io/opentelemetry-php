<?php

declare (strict_types=1);
namespace OpenTelemetry\API\Baggage;

final class BaggageBuilder implements \OpenTelemetry\API\Baggage\BaggageBuilderInterface
{
    /** @param array<string, Entry> $entries */
    public function __construct(private array $entries = [])
    {
    }
    /** @inheritDoc */
    #[\Override]
    public function remove(string $key): \OpenTelemetry\API\Baggage\BaggageBuilderInterface
    {
        unset($this->entries[$key]);
        return $this;
    }
    /** @inheritDoc */
    #[\Override]
    public function set(string $key, $value, ?\OpenTelemetry\API\Baggage\MetadataInterface $metadata = null): \OpenTelemetry\API\Baggage\BaggageBuilderInterface
    {
        if ($key === '') {
            return $this;
        }
        $metadata ??= \OpenTelemetry\API\Baggage\Metadata::getEmpty();
        $this->entries[$key] = new \OpenTelemetry\API\Baggage\Entry($value, $metadata);
        return $this;
    }
    #[\Override]
    public function build(): \OpenTelemetry\API\Baggage\BaggageInterface
    {
        return new \OpenTelemetry\API\Baggage\Baggage($this->entries);
    }
}
