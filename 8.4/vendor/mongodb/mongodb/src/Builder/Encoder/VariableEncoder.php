<?php

declare (strict_types=1);
namespace Odigos\MongoDB\Builder\Encoder;

use Odigos\MongoDB\Builder\Expression\Variable;
use Odigos\MongoDB\Codec\EncodeIfSupported;
use Odigos\MongoDB\Codec\Encoder;
use Odigos\MongoDB\Exception\UnsupportedValueException;
/**
 * @template-implements Encoder<string, Variable>
 * @internal
 */
final class VariableEncoder implements Encoder
{
    /** @template-use EncodeIfSupported<string, Variable> */
    use EncodeIfSupported;
    public function canEncode(mixed $value): bool
    {
        return $value instanceof Variable;
    }
    public function encode(mixed $value): string
    {
        if (!$this->canEncode($value)) {
            throw UnsupportedValueException::invalidEncodableValue($value);
        }
        // TODO: needs method because interfaces can't have properties
        return '$$' . $value->name;
    }
}
