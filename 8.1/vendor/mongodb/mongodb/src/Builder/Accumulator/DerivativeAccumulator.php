<?php

/**
 * THIS FILE IS AUTO-GENERATED. ANY CHANGES WILL BE LOST!
 */
declare (strict_types=1);
namespace Odigos\MongoDB\Builder\Accumulator;

use DateTimeInterface;
use MongoDB\BSON\Decimal128;
use MongoDB\BSON\Int64;
use MongoDB\BSON\UTCDateTime;
use Odigos\MongoDB\Builder\Expression\ResolvesToDate;
use Odigos\MongoDB\Builder\Expression\ResolvesToNumber;
use Odigos\MongoDB\Builder\Expression\ResolvesToString;
use Odigos\MongoDB\Builder\Type\Encode;
use Odigos\MongoDB\Builder\Type\OperatorInterface;
use Odigos\MongoDB\Builder\Type\Optional;
use Odigos\MongoDB\Builder\Type\TimeUnit;
use Odigos\MongoDB\Builder\Type\WindowInterface;
use Odigos\MongoDB\Exception\InvalidArgumentException;
use function is_string;
use function str_starts_with;
/**
 * Returns the average rate of change within the specified window.
 * New in MongoDB 5.0.
 *
 * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/derivative/
 * @internal
 */
final class DerivativeAccumulator implements WindowInterface, OperatorInterface
{
    public const ENCODE = Encode::Object;
    public const NAME = '$derivative';
    public const PROPERTIES = ['input' => 'input', 'unit' => 'unit'];
    /** @var DateTimeInterface|Decimal128|Int64|ResolvesToDate|ResolvesToNumber|UTCDateTime|float|int|string $input */
    public readonly DateTimeInterface|Decimal128|Int64|UTCDateTime|ResolvesToDate|ResolvesToNumber|float|int|string $input;
    /**
     * @var Optional|ResolvesToString|TimeUnit|string $unit A string that specifies the time unit. Use one of these strings: "week", "day","hour", "minute", "second", "millisecond".
     * If the sortBy field is not a date, you must omit a unit. If you specify a unit, you must specify a date in the sortBy field.
     */
    public readonly Optional|ResolvesToString|TimeUnit|string $unit;
    /**
     * @param DateTimeInterface|Decimal128|Int64|ResolvesToDate|ResolvesToNumber|UTCDateTime|float|int|string $input
     * @param Optional|ResolvesToString|TimeUnit|string $unit A string that specifies the time unit. Use one of these strings: "week", "day","hour", "minute", "second", "millisecond".
     * If the sortBy field is not a date, you must omit a unit. If you specify a unit, you must specify a date in the sortBy field.
     */
    public function __construct(DateTimeInterface|Decimal128|Int64|UTCDateTime|ResolvesToDate|ResolvesToNumber|float|int|string $input, Optional|ResolvesToString|TimeUnit|string $unit = Optional::Undefined)
    {
        if (is_string($input) && !str_starts_with($input, '$')) {
            throw new InvalidArgumentException('Argument $input can be an expression, field paths and variable names must be prefixed by "$" or "$$".');
        }
        $this->input = $input;
        $this->unit = $unit;
    }
}
