<?php

/**
 * THIS FILE IS AUTO-GENERATED. ANY CHANGES WILL BE LOST!
 */
declare (strict_types=1);
namespace Odigos\MongoDB\Builder\Expression;

use MongoDB\BSON\PackedArray;
use Odigos\MongoDB\Builder\Type\Encode;
use Odigos\MongoDB\Builder\Type\OperatorInterface;
use Odigos\MongoDB\Exception\InvalidArgumentException;
use Odigos\MongoDB\Model\BSONArray;
use function array_is_list;
use function is_array;
use function is_string;
use function str_starts_with;
/**
 * Returns true if no element of a set evaluates to false, otherwise, returns false. Accepts a single argument expression.
 *
 * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/allElementsTrue/
 * @internal
 */
final class AllElementsTrueOperator implements ResolvesToBool, OperatorInterface
{
    public const ENCODE = Encode::Array;
    public const NAME = '$allElementsTrue';
    public const PROPERTIES = ['expression' => 'expression'];
    /** @var BSONArray|PackedArray|ResolvesToArray|array|string $expression */
    public readonly PackedArray|ResolvesToArray|BSONArray|array|string $expression;
    /**
     * @param BSONArray|PackedArray|ResolvesToArray|array|string $expression
     */
    public function __construct(PackedArray|ResolvesToArray|BSONArray|array|string $expression)
    {
        if (is_string($expression) && !str_starts_with($expression, '$')) {
            throw new InvalidArgumentException('Argument $expression can be an expression, field paths and variable names must be prefixed by "$" or "$$".');
        }
        if (is_array($expression) && !array_is_list($expression)) {
            throw new InvalidArgumentException('Expected $expression argument to be a list, got an associative array.');
        }
        $this->expression = $expression;
    }
}
