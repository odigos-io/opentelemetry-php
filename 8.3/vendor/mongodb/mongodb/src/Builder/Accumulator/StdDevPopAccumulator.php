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
 * Calculates the population standard deviation of the input values. Use if the values encompass the entire population of data you want to represent and do not wish to generalize about a larger population. $stdDevPop ignores non-numeric values.
 * If the values represent only a sample of a population of data from which to generalize about the population, use $stdDevSamp instead.
 * Changed in MongoDB 5.0: Available in the $setWindowFields stage.
 *
 * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/stdDevPop/
 * @internal
 */
final class StdDevPopAccumulator implements AccumulatorInterface, WindowInterface, OperatorInterface
{
    public const ENCODE = Encode::Single;
    public const NAME = '$stdDevPop';
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
