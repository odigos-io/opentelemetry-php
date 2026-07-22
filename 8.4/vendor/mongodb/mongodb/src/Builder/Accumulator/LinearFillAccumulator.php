<?php

/**
 * THIS FILE IS AUTO-GENERATED. ANY CHANGES WILL BE LOST!
 */
declare (strict_types=1);
namespace Odigos\MongoDB\Builder\Accumulator;

use MongoDB\BSON\Decimal128;
use MongoDB\BSON\Int64;
use Odigos\MongoDB\Builder\Expression\ResolvesToNumber;
use Odigos\MongoDB\Builder\Type\Encode;
use Odigos\MongoDB\Builder\Type\OperatorInterface;
use Odigos\MongoDB\Builder\Type\WindowInterface;
use Odigos\MongoDB\Exception\InvalidArgumentException;
use function is_string;
use function str_starts_with;
/**
 * Fills null and missing fields in a window using linear interpolation based on surrounding field values.
 * Available in the $setWindowFields stage.
 * New in MongoDB 5.3.
 *
 * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/linearFill/
 * @internal
 */
final class LinearFillAccumulator implements WindowInterface, OperatorInterface
{
    public const ENCODE = Encode::Single;
    public const NAME = '$linearFill';
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
