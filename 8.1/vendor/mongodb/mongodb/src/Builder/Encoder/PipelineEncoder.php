<?php

declare (strict_types=1);
namespace Odigos\MongoDB\Builder\Encoder;

use Odigos\MongoDB\Builder\Pipeline;
use Odigos\MongoDB\Codec\EncodeIfSupported;
use Odigos\MongoDB\Codec\Encoder;
use Odigos\MongoDB\Exception\UnsupportedValueException;
/**
 * @template-implements Encoder<list<mixed>, Pipeline>
 * @internal
 */
final class PipelineEncoder implements Encoder
{
    /** @template-use EncodeIfSupported<list<mixed>, Pipeline> */
    use EncodeIfSupported;
    use RecursiveEncode;
    /** @psalm-assert-if-true Pipeline $value */
    public function canEncode(mixed $value): bool
    {
        return $value instanceof Pipeline;
    }
    /** @return list<mixed> */
    public function encode(mixed $value): array
    {
        if (!$this->canEncode($value)) {
            throw UnsupportedValueException::invalidEncodableValue($value);
        }
        $encoded = [];
        foreach ($value->getIterator() as $stage) {
            $encoded[] = $this->recursiveEncode($stage);
        }
        return $encoded;
    }
}
