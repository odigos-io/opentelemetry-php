<?php

declare (strict_types=1);
namespace Odigos\MongoDB\Builder;

use DateTimeInterface;
use MongoDB\BSON\Type;
use Odigos\MongoDB\Builder\Encoder\CombinedFieldQueryEncoder;
use Odigos\MongoDB\Builder\Encoder\DateTimeEncoder;
use Odigos\MongoDB\Builder\Encoder\DictionaryEncoder;
use Odigos\MongoDB\Builder\Encoder\FieldPathEncoder;
use Odigos\MongoDB\Builder\Encoder\OperatorEncoder;
use Odigos\MongoDB\Builder\Encoder\OutputWindowEncoder;
use Odigos\MongoDB\Builder\Encoder\PipelineEncoder;
use Odigos\MongoDB\Builder\Encoder\QueryEncoder;
use Odigos\MongoDB\Builder\Encoder\VariableEncoder;
use Odigos\MongoDB\Builder\Expression\Variable;
use Odigos\MongoDB\Builder\Type\CombinedFieldQuery;
use Odigos\MongoDB\Builder\Type\DictionaryInterface;
use Odigos\MongoDB\Builder\Type\ExpressionInterface;
use Odigos\MongoDB\Builder\Type\FieldPathInterface;
use Odigos\MongoDB\Builder\Type\OperatorInterface;
use Odigos\MongoDB\Builder\Type\OutputWindow;
use Odigos\MongoDB\Builder\Type\QueryInterface;
use Odigos\MongoDB\Builder\Type\QueryObject;
use Odigos\MongoDB\Builder\Type\StageInterface;
use Odigos\MongoDB\Codec\EncodeIfSupported;
use Odigos\MongoDB\Codec\Encoder;
use Odigos\MongoDB\Exception\UnsupportedValueException;
use stdClass;
use WeakReference;
use function array_key_exists;
use function is_object;
/** @template-implements Encoder<Type|stdClass|array|string|int, Pipeline|StageInterface|ExpressionInterface|QueryInterface> */
final class BuilderEncoder implements Encoder
{
    /** @template-use EncodeIfSupported<Type|stdClass|array|string|int, Pipeline|StageInterface|ExpressionInterface|QueryInterface> */
    use EncodeIfSupported;
    /** @var array<class-string, Encoder> */
    private array $encoders;
    /** @var array<class-string, Encoder|null> */
    private array $cachedEncoders = [];
    /** @param array<class-string, Encoder> $encoders */
    public function __construct(array $encoders = [])
    {
        $self = WeakReference::create($this);
        $this->encoders = $encoders + [Pipeline::class => new PipelineEncoder($self), Variable::class => new VariableEncoder(), DictionaryInterface::class => new DictionaryEncoder(), FieldPathInterface::class => new FieldPathEncoder(), CombinedFieldQuery::class => new CombinedFieldQueryEncoder($self), QueryObject::class => new QueryEncoder($self), OutputWindow::class => new OutputWindowEncoder($self), OperatorInterface::class => new OperatorEncoder($self), DateTimeInterface::class => new DateTimeEncoder()];
    }
    /** @psalm-assert-if-true object $value */
    public function canEncode(mixed $value): bool
    {
        if (!is_object($value)) {
            return \false;
        }
        return (bool) $this->getEncoderFor($value)?->canEncode($value);
    }
    public function encode(mixed $value): Type|stdClass|array|string|int
    {
        $encoder = $this->getEncoderFor($value);
        if (!$encoder?->canEncode($value)) {
            throw UnsupportedValueException::invalidEncodableValue($value);
        }
        return $encoder->encode($value);
    }
    private function getEncoderFor(object $value): Encoder|null
    {
        $valueClass = $value::class;
        if (array_key_exists($valueClass, $this->cachedEncoders)) {
            return $this->cachedEncoders[$valueClass];
        }
        // First attempt: match class name exactly
        if (isset($this->encoders[$valueClass])) {
            return $this->cachedEncoders[$valueClass] = $this->encoders[$valueClass];
        }
        // Second attempt: catch child classes
        foreach ($this->encoders as $className => $encoder) {
            if ($value instanceof $className) {
                return $this->cachedEncoders[$valueClass] = $encoder;
            }
        }
        return $this->cachedEncoders[$valueClass] = null;
    }
}
