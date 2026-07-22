<?php

/**
 * THIS FILE IS AUTO-GENERATED. ANY CHANGES WILL BE LOST!
 */
declare (strict_types=1);
namespace Odigos\MongoDB\Builder\Accumulator;

use MongoDB\BSON\Decimal128;
use MongoDB\BSON\Int64;
use Odigos\MongoDB\Builder\Expression\ResolvesToNumber;
use Odigos\MongoDB\Builder\Type\AccumulatorInterface;
use Odigos\MongoDB\Builder\Type\Encode;
use Odigos\MongoDB\Builder\Type\OperatorInterface;
use Odigos\MongoDB\Builder\Type\WindowInterface;
use Odigos\MongoDB\Exception\InvalidArgumentException;
use function is_string;
use function str_starts_with;
/**
 * Returns an average of numerical values. Ignores non-numeric values.
 * Changed in MongoDB 5.0: Available in the $setWindowFields stage.
 *
 * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/avg/
 * @internal
 */
final class AvgAccumulator implements AccumulatorInterface, WindowInterface, OperatorInterface
{
    public const ENCODE = Encode::Single;
    public const NAME = '$avg';
    public const PROPERTIES = ['expression' => 'expression'];
    /** @var Decimal128|Int64|ResolvesToNumber|float|int|string $expression */
    public readonly Decimal128|Int64|ResolvesToNumber|float|int|string $expression;
    /**
     * @param Decimal128|Int64|ResolvesToNumber|float|int|string $expression
     */
    public function __construct(Decimal128|Int64|ResolvesToNumber|float|int|string $expression)
    {
        if (is_string($expression) && !str_starts_with($expression, '$')) {
            throw new InvalidArgumentException('Argument $expression can be an expression, field paths and variable names must be prefixed by "$" or "$$".');
        }
        $this->expression = $expression;
    }
}
