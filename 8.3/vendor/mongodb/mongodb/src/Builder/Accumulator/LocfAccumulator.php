<?php

/**
 * THIS FILE IS AUTO-GENERATED. ANY CHANGES WILL BE LOST!
 */
declare (strict_types=1);
namespace Odigos\MongoDB\Builder\Accumulator;

use DateTimeInterface;
use MongoDB\BSON\Type;
use Odigos\MongoDB\Builder\Type\Encode;
use Odigos\MongoDB\Builder\Type\ExpressionInterface;
use Odigos\MongoDB\Builder\Type\OperatorInterface;
use Odigos\MongoDB\Builder\Type\WindowInterface;
use stdClass;
/**
 * Last observation carried forward. Sets values for null and missing fields in a window to the last non-null value for the field.
 * Available in the $setWindowFields stage.
 * New in MongoDB 5.2.
 *
 * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/locf/
 * @internal
 */
final class LocfAccumulator implements WindowInterface, OperatorInterface
{
    public const ENCODE = Encode::Single;
    public const NAME = '$locf';
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
