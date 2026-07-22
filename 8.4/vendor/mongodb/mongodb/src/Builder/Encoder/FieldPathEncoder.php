<?php

declare (strict_types=1);
namespace Odigos\MongoDB\Builder\Encoder;

use Odigos\MongoDB\Builder\Type\FieldPathInterface;
use Odigos\MongoDB\Codec\EncodeIfSupported;
use Odigos\MongoDB\Codec\Encoder;
use Odigos\MongoDB\Exception\UnsupportedValueException;
/**
 * @template-implements Encoder<string, FieldPathInterface>
 * @internal
 */
final class FieldPathEncoder implements Encoder
{
    /** @template-use EncodeIfSupported<string, FieldPathInterface> */
    use EncodeIfSupported;
    public function canEncode(mixed $value): bool
    {
        return $value instanceof FieldPathInterface;
    }
    public function encode(mixed $value): string
    {
        if (!$this->canEncode($value)) {
            throw UnsupportedValueException::invalidEncodableValue($value);
        }
        return '$' . $value->name;
    }
}
