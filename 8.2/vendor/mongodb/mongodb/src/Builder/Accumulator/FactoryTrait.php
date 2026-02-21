<?php

/**
 * THIS FILE IS AUTO-GENERATED. ANY CHANGES WILL BE LOST!
 */
declare (strict_types=1);
namespace MongoDB\Builder\Accumulator;

use DateTimeInterface;
use MongoDB\BSON\Decimal128;
use MongoDB\BSON\Document;
use MongoDB\BSON\Int64;
use MongoDB\BSON\Javascript;
use MongoDB\BSON\PackedArray;
use MongoDB\BSON\Serializable;
use MongoDB\BSON\Type;
use MongoDB\BSON\UTCDateTime;
use MongoDB\Builder\Expression\ResolvesToArray;
use MongoDB\Builder\Expression\ResolvesToDate;
use MongoDB\Builder\Expression\ResolvesToInt;
use MongoDB\Builder\Expression\ResolvesToNumber;
use MongoDB\Builder\Expression\ResolvesToObject;
use MongoDB\Builder\Expression\ResolvesToString;
use MongoDB\Builder\Type\ExpressionInterface;
use MongoDB\Builder\Type\Optional;
use MongoDB\Builder\Type\TimeUnit;
use MongoDB\Model\BSONArray;
use stdClass;
/**
 * @internal
 */
trait FactoryTrait
{
    /**
     * Defines a custom accumulator function.
     * New in MongoDB 4.4.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/accumulator/
     * @param Javascript|string $init Function used to initialize the state. The init function receives its arguments from the initArgs array expression. You can specify the function definition as either BSON type Code or String.
     * @param Javascript|string $accumulate Function used to accumulate documents. The accumulate function receives its arguments from the current state and accumulateArgs array expression. The result of the accumulate function becomes the new state. You can specify the function definition as either BSON type Code or String.
     * @param BSONArray|PackedArray|ResolvesToArray|array|string $accumulateArgs Arguments passed to the accumulate function. You can use accumulateArgs to specify what field value(s) to pass to the accumulate function.
     * @param Javascript|string $merge Function used to merge two internal states. merge must be either a String or Code BSON type. merge returns the combined result of the two merged states. For information on when the merge function is called, see Merge Two States with $merge.
     * @param string $lang The language used in the $accumulator code.
     * @param Optional|BSONArray|PackedArray|ResolvesToArray|array|string $initArgs Arguments passed to the init function.
     * @param Optional|Javascript|string $finalize Function used to update the result of the accumulation.
     */
    public static function accumulator(Javascript|string $init, Javascript|string $accumulate, PackedArray|ResolvesToArray|BSONArray|array|string $accumulateArgs, Javascript|string $merge, string $lang, Optional|PackedArray|ResolvesToArray|BSONArray|array|string $initArgs = Optional::Undefined, Optional|Javascript|string $finalize = Optional::Undefined): \MongoDB\Builder\Accumulator\AccumulatorAccumulator
    {
        return new \MongoDB\Builder\Accumulator\AccumulatorAccumulator($init, $accumulate, $accumulateArgs, $merge, $lang, $initArgs, $finalize);
    }
    /**
     * Returns an array of unique expression values for each group. Order of the array elements is undefined.
     * Changed in MongoDB 5.0: Available in the $setWindowFields stage.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/addToSet/
     * @param DateTimeInterface|ExpressionInterface|Type|array|bool|float|int|null|stdClass|string $expression
     */
    public static function addToSet(DateTimeInterface|Type|ExpressionInterface|stdClass|array|bool|float|int|null|string $expression): \MongoDB\Builder\Accumulator\AddToSetAccumulator
    {
        return new \MongoDB\Builder\Accumulator\AddToSetAccumulator($expression);
    }
    /**
     * Returns an average of numerical values. Ignores non-numeric values.
     * Changed in MongoDB 5.0: Available in the $setWindowFields stage.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/avg/
     * @param Decimal128|Int64|ResolvesToNumber|float|int|string $expression
     */
    public static function avg(Decimal128|Int64|ResolvesToNumber|float|int|string $expression): \MongoDB\Builder\Accumulator\AvgAccumulator
    {
        return new \MongoDB\Builder\Accumulator\AvgAccumulator($expression);
    }
    /**
     * Returns the bottom element within a group according to the specified sort order.
     * New in MongoDB 5.2: Available in the $group and $setWindowFields stages.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/bottom/
     * @param Document|Serializable|array|stdClass $sortBy Specifies the order of results, with syntax similar to $sort.
     * @param DateTimeInterface|ExpressionInterface|Type|array|bool|float|int|null|stdClass|string $output Represents the output for each element in the group and can be any expression.
     */
    public static function bottom(Document|Serializable|stdClass|array $sortBy, DateTimeInterface|Type|ExpressionInterface|stdClass|array|bool|float|int|null|string $output): \MongoDB\Builder\Accumulator\BottomAccumulator
    {
        return new \MongoDB\Builder\Accumulator\BottomAccumulator($sortBy, $output);
    }
    /**
     * Returns an aggregation of the bottom n elements within a group, according to the specified sort order. If the group contains fewer than n elements, $bottomN returns all elements in the group.
     * New in MongoDB 5.2.
     * Available in the $group and $setWindowFields stages.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/bottomN/
     * @param ResolvesToInt|int|string $n Limits the number of results per group and has to be a positive integral expression that is either a constant or depends on the _id value for $group.
     * @param Document|Serializable|array|stdClass $sortBy Specifies the order of results, with syntax similar to $sort.
     * @param DateTimeInterface|ExpressionInterface|Type|array|bool|float|int|null|stdClass|string $output Represents the output for each element in the group and can be any expression.
     */
    public static function bottomN(ResolvesToInt|int|string $n, Document|Serializable|stdClass|array $sortBy, DateTimeInterface|Type|ExpressionInterface|stdClass|array|bool|float|int|null|string $output): \MongoDB\Builder\Accumulator\BottomNAccumulator
    {
        return new \MongoDB\Builder\Accumulator\BottomNAccumulator($n, $sortBy, $output);
    }
    /**
     * Returns the number of documents in the group or window.
     * Distinct from the $count pipeline stage.
     * New in MongoDB 5.0.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/count-accumulator/
     */
    public static function count(): \MongoDB\Builder\Accumulator\CountAccumulator
    {
        return new \MongoDB\Builder\Accumulator\CountAccumulator();
    }
    /**
     * Returns the population covariance of two numeric expressions.
     * New in MongoDB 5.0.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/covariancePop/
     * @param Decimal128|Int64|ResolvesToNumber|float|int|string $expression1
     * @param Decimal128|Int64|ResolvesToNumber|float|int|string $expression2
     */
    public static function covariancePop(Decimal128|Int64|ResolvesToNumber|float|int|string $expression1, Decimal128|Int64|ResolvesToNumber|float|int|string $expression2): \MongoDB\Builder\Accumulator\CovariancePopAccumulator
    {
        return new \MongoDB\Builder\Accumulator\CovariancePopAccumulator($expression1, $expression2);
    }
    /**
     * Returns the sample covariance of two numeric expressions.
     * New in MongoDB 5.0.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/covarianceSamp/
     * @param Decimal128|Int64|ResolvesToNumber|float|int|string $expression1
     * @param Decimal128|Int64|ResolvesToNumber|float|int|string $expression2
     */
    public static function covarianceSamp(Decimal128|Int64|ResolvesToNumber|float|int|string $expression1, Decimal128|Int64|ResolvesToNumber|float|int|string $expression2): \MongoDB\Builder\Accumulator\CovarianceSampAccumulator
    {
        return new \MongoDB\Builder\Accumulator\CovarianceSampAccumulator($expression1, $expression2);
    }
    /**
     * Returns the document position (known as the rank) relative to other documents in the $setWindowFields stage partition. There are no gaps in the ranks. Ties receive the same rank.
     * New in MongoDB 5.0.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/denseRank/
     */
    public static function denseRank(): \MongoDB\Builder\Accumulator\DenseRankAccumulator
    {
        return new \MongoDB\Builder\Accumulator\DenseRankAccumulator();
    }
    /**
     * Returns the average rate of change within the specified window.
     * New in MongoDB 5.0.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/derivative/
     * @param DateTimeInterface|Decimal128|Int64|ResolvesToDate|ResolvesToNumber|UTCDateTime|float|int|string $input
     * @param Optional|ResolvesToString|TimeUnit|string $unit A string that specifies the time unit. Use one of these strings: "week", "day","hour", "minute", "second", "millisecond".
     * If the sortBy field is not a date, you must omit a unit. If you specify a unit, you must specify a date in the sortBy field.
     */
    public static function derivative(DateTimeInterface|Decimal128|Int64|UTCDateTime|ResolvesToDate|ResolvesToNumber|float|int|string $input, Optional|ResolvesToString|TimeUnit|string $unit = Optional::Undefined): \MongoDB\Builder\Accumulator\DerivativeAccumulator
    {
        return new \MongoDB\Builder\Accumulator\DerivativeAccumulator($input, $unit);
    }
    /**
     * Returns the position of a document (known as the document number) in the $setWindowFields stage partition. Ties result in different adjacent document numbers.
     * New in MongoDB 5.0.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/documentNumber/
     */
    public static function documentNumber(): \MongoDB\Builder\Accumulator\DocumentNumberAccumulator
    {
        return new \MongoDB\Builder\Accumulator\DocumentNumberAccumulator();
    }
    /**
     * Returns the exponential moving average for the numeric expression.
     * New in MongoDB 5.0.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/expMovingAvg/
     * @param Decimal128|Int64|ResolvesToNumber|float|int|string $input
     * @param Optional|int $N An integer that specifies the number of historical documents that have a significant mathematical weight in the exponential moving average calculation, with the most recent documents contributing the most weight.
     * You must specify either N or alpha. You cannot specify both.
     * The N value is used in this formula to calculate the current result based on the expression value from the current document being read and the previous result of the calculation:
     * @param Optional|Int64|float|int $alpha A double that specifies the exponential decay value to use in the exponential moving average calculation. A higher alpha value assigns a lower mathematical significance to previous results from the calculation.
     * You must specify either N or alpha. You cannot specify both.
     */
    public static function expMovingAvg(Decimal128|Int64|ResolvesToNumber|float|int|string $input, Optional|int $N = Optional::Undefined, Optional|Int64|float|int $alpha = Optional::Undefined): \MongoDB\Builder\Accumulator\ExpMovingAvgAccumulator
    {
        return new \MongoDB\Builder\Accumulator\ExpMovingAvgAccumulator($input, $N, $alpha);
    }
    /**
     * Returns the result of an expression for the first document in a group or window.
     * Changed in MongoDB 5.0: Available in the $setWindowFields stage.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/first/
     * @param DateTimeInterface|ExpressionInterface|Type|array|bool|float|int|null|stdClass|string $expression
     */
    public static function first(DateTimeInterface|Type|ExpressionInterface|stdClass|array|bool|float|int|null|string $expression): \MongoDB\Builder\Accumulator\FirstAccumulator
    {
        return new \MongoDB\Builder\Accumulator\FirstAccumulator($expression);
    }
    /**
     * Returns an aggregation of the first n elements within a group.
     * The elements returned are meaningful only if in a specified sort order.
     * If the group contains fewer than n elements, $firstN returns all elements in the group.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/firstN/
     * @param DateTimeInterface|ExpressionInterface|Type|array|bool|float|int|null|stdClass|string $input An expression that resolves to the array from which to return n elements.
     * @param ResolvesToInt|int|string $n A positive integral expression that is either a constant or depends on the _id value for $group.
     */
    public static function firstN(DateTimeInterface|Type|ExpressionInterface|stdClass|array|bool|float|int|null|string $input, ResolvesToInt|int|string $n): \MongoDB\Builder\Accumulator\FirstNAccumulator
    {
        return new \MongoDB\Builder\Accumulator\FirstNAccumulator($input, $n);
    }
    /**
     * Returns the approximation of the area under a curve.
     * New in MongoDB 5.0.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/integral/
     * @param DateTimeInterface|Decimal128|Int64|ResolvesToDate|ResolvesToNumber|UTCDateTime|float|int|string $input
     * @param Optional|ResolvesToString|TimeUnit|string $unit A string that specifies the time unit. Use one of these strings: "week", "day","hour", "minute", "second", "millisecond".
     * If the sortBy field is not a date, you must omit a unit. If you specify a unit, you must specify a date in the sortBy field.
     */
    public static function integral(DateTimeInterface|Decimal128|Int64|UTCDateTime|ResolvesToDate|ResolvesToNumber|float|int|string $input, Optional|ResolvesToString|TimeUnit|string $unit = Optional::Undefined): \MongoDB\Builder\Accumulator\IntegralAccumulator
    {
        return new \MongoDB\Builder\Accumulator\IntegralAccumulator($input, $unit);
    }
    /**
     * Returns the result of an expression for the last document in a group or window.
     * Changed in MongoDB 5.0: Available in the $setWindowFields stage.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/last/
     * @param DateTimeInterface|ExpressionInterface|Type|array|bool|float|int|null|stdClass|string $expression
     */
    public static function last(DateTimeInterface|Type|ExpressionInterface|stdClass|array|bool|float|int|null|string $expression): \MongoDB\Builder\Accumulator\LastAccumulator
    {
        return new \MongoDB\Builder\Accumulator\LastAccumulator($expression);
    }
    /**
     * Returns an aggregation of the last n elements within a group.
     * The elements returned are meaningful only if in a specified sort order.
     * If the group contains fewer than n elements, $lastN returns all elements in the group.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/lastN/
     * @param BSONArray|PackedArray|ResolvesToArray|array|string $input An expression that resolves to the array from which to return n elements.
     * @param ResolvesToInt|int|string $n An expression that resolves to a positive integer. The integer specifies the number of array elements that $firstN returns.
     */
    public static function lastN(PackedArray|ResolvesToArray|BSONArray|array|string $input, ResolvesToInt|int|string $n): \MongoDB\Builder\Accumulator\LastNAccumulator
    {
        return new \MongoDB\Builder\Accumulator\LastNAccumulator($input, $n);
    }
    /**
     * Fills null and missing fields in a window using linear interpolation based on surrounding field values.
     * Available in the $setWindowFields stage.
     * New in MongoDB 5.3.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/linearFill/
     * @param Decimal128|Int64|ResolvesToNumber|float|int|string $expression
     */
    public static function linearFill(Decimal128|Int64|ResolvesToNumber|float|int|string $expression): \MongoDB\Builder\Accumulator\LinearFillAccumulator
    {
        return new \MongoDB\Builder\Accumulator\LinearFillAccumulator($expression);
    }
    /**
     * Last observation carried forward. Sets values for null and missing fields in a window to the last non-null value for the field.
     * Available in the $setWindowFields stage.
     * New in MongoDB 5.2.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/locf/
     * @param DateTimeInterface|ExpressionInterface|Type|array|bool|float|int|null|stdClass|string $expression
     */
    public static function locf(DateTimeInterface|Type|ExpressionInterface|stdClass|array|bool|float|int|null|string $expression): \MongoDB\Builder\Accumulator\LocfAccumulator
    {
        return new \MongoDB\Builder\Accumulator\LocfAccumulator($expression);
    }
    /**
     * Returns the maximum value that results from applying an expression to each document.
     * Changed in MongoDB 5.0: Available in the $setWindowFields stage.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/max/
     * @param DateTimeInterface|ExpressionInterface|Type|array|bool|float|int|null|stdClass|string $expression
     */
    public static function max(DateTimeInterface|Type|ExpressionInterface|stdClass|array|bool|float|int|null|string $expression): \MongoDB\Builder\Accumulator\MaxAccumulator
    {
        return new \MongoDB\Builder\Accumulator\MaxAccumulator($expression);
    }
    /**
     * Returns the n largest values in an array. Distinct from the $maxN accumulator.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/maxN/
     * @param BSONArray|PackedArray|ResolvesToArray|array|string $input An expression that resolves to the array from which to return the maximal n elements.
     * @param ResolvesToInt|int|string $n An expression that resolves to a positive integer. The integer specifies the number of array elements that $maxN returns.
     */
    public static function maxN(PackedArray|ResolvesToArray|BSONArray|array|string $input, ResolvesToInt|int|string $n): \MongoDB\Builder\Accumulator\MaxNAccumulator
    {
        return new \MongoDB\Builder\Accumulator\MaxNAccumulator($input, $n);
    }
    /**
     * Returns an approximation of the median, the 50th percentile, as a scalar value.
     * New in MongoDB 7.0.
     * This operator is available as an accumulator in these stages:
     * $group
     * $setWindowFields
     * It is also available as an aggregation expression.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/median/
     * @param Decimal128|Int64|ResolvesToNumber|float|int|string $input $median calculates the 50th percentile value of this data. input must be a field name or an expression that evaluates to a numeric type. If the expression cannot be converted to a numeric type, the $median calculation ignores it.
     * @param string $method The method that mongod uses to calculate the 50th percentile value. The method must be 'approximate'.
     */
    public static function median(Decimal128|Int64|ResolvesToNumber|float|int|string $input, string $method): \MongoDB\Builder\Accumulator\MedianAccumulator
    {
        return new \MongoDB\Builder\Accumulator\MedianAccumulator($input, $method);
    }
    /**
     * Combines multiple documents into a single document.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/mergeObjects/
     * @param Document|ResolvesToObject|Serializable|array|stdClass|string $document Any valid expression that resolves to a document.
     */
    public static function mergeObjects(Document|Serializable|ResolvesToObject|stdClass|array|string $document): \MongoDB\Builder\Accumulator\MergeObjectsAccumulator
    {
        return new \MongoDB\Builder\Accumulator\MergeObjectsAccumulator($document);
    }
    /**
     * Returns the minimum value that results from applying an expression to each document.
     * Changed in MongoDB 5.0: Available in the $setWindowFields stage.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/min/
     * @param DateTimeInterface|ExpressionInterface|Type|array|bool|float|int|null|stdClass|string $expression
     */
    public static function min(DateTimeInterface|Type|ExpressionInterface|stdClass|array|bool|float|int|null|string $expression): \MongoDB\Builder\Accumulator\MinAccumulator
    {
        return new \MongoDB\Builder\Accumulator\MinAccumulator($expression);
    }
    /**
     * Returns the n smallest values in an array. Distinct from the $minN accumulator.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/minN/
     * @param BSONArray|PackedArray|ResolvesToArray|array|string $input An expression that resolves to the array from which to return the maximal n elements.
     * @param ResolvesToInt|int|string $n An expression that resolves to a positive integer. The integer specifies the number of array elements that $maxN returns.
     */
    public static function minN(PackedArray|ResolvesToArray|BSONArray|array|string $input, ResolvesToInt|int|string $n): \MongoDB\Builder\Accumulator\MinNAccumulator
    {
        return new \MongoDB\Builder\Accumulator\MinNAccumulator($input, $n);
    }
    /**
     * Returns an array of scalar values that correspond to specified percentile values.
     * New in MongoDB 7.0.
     *
     * This operator is available as an accumulator in these stages:
     * $group
     *
     * $setWindowFields
     *
     * It is also available as an aggregation expression.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/percentile/
     * @param Decimal128|Int64|ResolvesToNumber|float|int|string $input $percentile calculates the percentile values of this data. input must be a field name or an expression that evaluates to a numeric type. If the expression cannot be converted to a numeric type, the $percentile calculation ignores it.
     * @param BSONArray|PackedArray|ResolvesToArray|array|string $p $percentile calculates a percentile value for each element in p. The elements represent percentages and must evaluate to numeric values in the range 0.0 to 1.0, inclusive.
     * $percentile returns results in the same order as the elements in p.
     * @param string $method The method that mongod uses to calculate the percentile value. The method must be 'approximate'.
     */
    public static function percentile(Decimal128|Int64|ResolvesToNumber|float|int|string $input, PackedArray|ResolvesToArray|BSONArray|array|string $p, string $method): \MongoDB\Builder\Accumulator\PercentileAccumulator
    {
        return new \MongoDB\Builder\Accumulator\PercentileAccumulator($input, $p, $method);
    }
    /**
     * Returns an array of values that result from applying an expression to each document.
     * Changed in MongoDB 5.0: Available in the $setWindowFields stage.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/push/
     * @param DateTimeInterface|ExpressionInterface|Type|array|bool|float|int|null|stdClass|string $expression
     */
    public static function push(DateTimeInterface|Type|ExpressionInterface|stdClass|array|bool|float|int|null|string $expression): \MongoDB\Builder\Accumulator\PushAccumulator
    {
        return new \MongoDB\Builder\Accumulator\PushAccumulator($expression);
    }
    /**
     * Returns the document position (known as the rank) relative to other documents in the $setWindowFields stage partition.
     * New in MongoDB 5.0.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/rank/
     */
    public static function rank(): \MongoDB\Builder\Accumulator\RankAccumulator
    {
        return new \MongoDB\Builder\Accumulator\RankAccumulator();
    }
    /**
     * Returns the value from an expression applied to a document in a specified position relative to the current document in the $setWindowFields stage partition.
     * New in MongoDB 5.0.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/shift/
     * @param DateTimeInterface|ExpressionInterface|Type|array|bool|float|int|null|stdClass|string $output Specifies an expression to evaluate and return in the output.
     * @param int $by Specifies an integer with a numeric document position relative to the current document in the output.
     * For example:
     * 1 specifies the document position after the current document.
     * -1 specifies the document position before the current document.
     * -2 specifies the document position that is two positions before the current document.
     * @param DateTimeInterface|ExpressionInterface|Type|array|bool|float|int|null|stdClass|string $default Specifies an optional default expression to evaluate if the document position is outside of the implicit $setWindowFields stage window. The implicit window contains all the documents in the partition.
     * The default expression must evaluate to a constant value.
     * If you do not specify a default expression, $shift returns null for documents whose positions are outside of the implicit $setWindowFields stage window.
     */
    public static function shift(DateTimeInterface|Type|ExpressionInterface|stdClass|array|bool|float|int|null|string $output, int $by, DateTimeInterface|Type|ExpressionInterface|stdClass|array|bool|float|int|null|string $default): \MongoDB\Builder\Accumulator\ShiftAccumulator
    {
        return new \MongoDB\Builder\Accumulator\ShiftAccumulator($output, $by, $default);
    }
    /**
     * Calculates the population standard deviation of the input values. Use if the values encompass the entire population of data you want to represent and do not wish to generalize about a larger population. $stdDevPop ignores non-numeric values.
     * If the values represent only a sample of a population of data from which to generalize about the population, use $stdDevSamp instead.
     * Changed in MongoDB 5.0: Available in the $setWindowFields stage.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/stdDevPop/
     * @param Decimal128|Int64|ResolvesToNumber|float|int|string $expression
     */
    public static function stdDevPop(Decimal128|Int64|ResolvesToNumber|float|int|string $expression): \MongoDB\Builder\Accumulator\StdDevPopAccumulator
    {
        return new \MongoDB\Builder\Accumulator\StdDevPopAccumulator($expression);
    }
    /**
     * Calculates the sample standard deviation of the input values. Use if the values encompass a sample of a population of data from which to generalize about the population. $stdDevSamp ignores non-numeric values.
     * If the values represent the entire population of data or you do not wish to generalize about a larger population, use $stdDevPop instead.
     * Changed in MongoDB 5.0: Available in the $setWindowFields stage.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/stdDevSamp/
     * @param Decimal128|Int64|ResolvesToNumber|float|int|string $expression
     */
    public static function stdDevSamp(Decimal128|Int64|ResolvesToNumber|float|int|string $expression): \MongoDB\Builder\Accumulator\StdDevSampAccumulator
    {
        return new \MongoDB\Builder\Accumulator\StdDevSampAccumulator($expression);
    }
    /**
     * Returns a sum of numerical values. Ignores non-numeric values.
     * Changed in MongoDB 5.0: Available in the $setWindowFields stage.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/sum/
     * @param Decimal128|Int64|ResolvesToNumber|float|int|string $expression
     */
    public static function sum(Decimal128|Int64|ResolvesToNumber|float|int|string $expression): \MongoDB\Builder\Accumulator\SumAccumulator
    {
        return new \MongoDB\Builder\Accumulator\SumAccumulator($expression);
    }
    /**
     * Returns the top element within a group according to the specified sort order.
     * New in MongoDB 5.2.
     *
     * Available in the $group and $setWindowFields stages.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/top/
     * @param Document|Serializable|array|stdClass $sortBy Specifies the order of results, with syntax similar to $sort.
     * @param DateTimeInterface|ExpressionInterface|Type|array|bool|float|int|null|stdClass|string $output Represents the output for each element in the group and can be any expression.
     */
    public static function top(Document|Serializable|stdClass|array $sortBy, DateTimeInterface|Type|ExpressionInterface|stdClass|array|bool|float|int|null|string $output): \MongoDB\Builder\Accumulator\TopAccumulator
    {
        return new \MongoDB\Builder\Accumulator\TopAccumulator($sortBy, $output);
    }
    /**
     * Returns an aggregation of the top n fields within a group, according to the specified sort order.
     * New in MongoDB 5.2.
     *
     * Available in the $group and $setWindowFields stages.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/topN/
     * @param ResolvesToInt|int|string $n limits the number of results per group and has to be a positive integral expression that is either a constant or depends on the _id value for $group.
     * @param Document|Serializable|array|stdClass $sortBy Specifies the order of results, with syntax similar to $sort.
     * @param DateTimeInterface|ExpressionInterface|Type|array|bool|float|int|null|stdClass|string $output Represents the output for each element in the group and can be any expression.
     */
    public static function topN(ResolvesToInt|int|string $n, Document|Serializable|stdClass|array $sortBy, DateTimeInterface|Type|ExpressionInterface|stdClass|array|bool|float|int|null|string $output): \MongoDB\Builder\Accumulator\TopNAccumulator
    {
        return new \MongoDB\Builder\Accumulator\TopNAccumulator($n, $sortBy, $output);
    }
}
