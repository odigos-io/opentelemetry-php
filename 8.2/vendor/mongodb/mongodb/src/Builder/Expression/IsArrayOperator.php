<?php

/**
 * THIS FILE IS AUTO-GENERATED. ANY CHANGES WILL BE LOST!
 */
declare (strict_types=1);
namespace Odigos\MongoDB\Builder\Expression;

use DateTimeInterface;
use MongoDB\BSON\Type;
use Odigos\MongoDB\Builder\Type\Encode;
use Odigos\MongoDB\Builder\Type\ExpressionInterface;
use Odigos\MongoDB\Builder\Type\OperatorInterface;
use stdClass;
/**
 * Determines if the operand is an array. Returns a boolean.
 *
 * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/isArray/
 * @internal
 */
final class IsArrayOperator implements ResolvesToBool, OperatorInterface
{
    public const ENCODE = Encode::Array;
    public const NAME = '$isArray';
    public const PROPERTIES = ['expression' => 'expression'];
    /** @var DateTimeInterface|ExpressionInterface|Type|array|bool|float|int|null|stdClass|string $expression */
    public readonly DateTimeInterface|Type|ExpressionInterface|stdClass|array|bool|float|int|null|string $expression;
    /**
     * @param DateTimeInterface|ExpressionInterface|Type|array|bool|float|int|null|stdClass|string $expression
     */
    public function __construct(DateTimeInterface|Type|ExpressionInterface|stdClass|array|bool|float|int|null|string $expression)
    {
        $this->expression = $expression;
    }
}
