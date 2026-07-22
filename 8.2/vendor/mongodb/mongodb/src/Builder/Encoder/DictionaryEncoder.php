<?php

declare (strict_types=1);
namespace Odigos\MongoDB\Builder\Encoder;

use Odigos\MongoDB\Builder\Type\DictionaryInterface;
use Odigos\MongoDB\Codec\EncodeIfSupported;
use Odigos\MongoDB\Codec\Encoder;
use Odigos\MongoDB\Exception\UnsupportedValueException;
use stdClass;
/**
 * @template-implements Encoder<string|int|array|stdClass, DictionaryInterface>
 * @internal
 */
final class DictionaryEncoder implements Encoder
{
    /** @template-use EncodeIfSupported<string|int|array|stdClass, DictionaryInterface> */
    use EncodeIfSupported;
    public function canEncode(mixed $value): bool
    {
        return $value instanceof DictionaryInterface;
    }
    public function encode(mixed $value): string|int|array|stdClass
    {
        if (!$this->canEncode($value)) {
            throw UnsupportedValueException::invalidEncodableValue($value);
        }
        return $value->getValue();
    }
}
