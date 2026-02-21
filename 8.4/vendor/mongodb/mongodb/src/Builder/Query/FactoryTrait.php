<?php

/**
 * THIS FILE IS AUTO-GENERATED. ANY CHANGES WILL BE LOST!
 */
declare (strict_types=1);
namespace MongoDB\Builder\Query;

use DateTimeInterface;
use MongoDB\BSON\Binary;
use MongoDB\BSON\Decimal128;
use MongoDB\BSON\Document;
use MongoDB\BSON\Int64;
use MongoDB\BSON\Javascript;
use MongoDB\BSON\PackedArray;
use MongoDB\BSON\Regex;
use MongoDB\BSON\Serializable;
use MongoDB\BSON\Type;
use MongoDB\Builder\Expression\ResolvesToDouble;
use MongoDB\Builder\Type\ExpressionInterface;
use MongoDB\Builder\Type\FieldQueryInterface;
use MongoDB\Builder\Type\GeometryInterface;
use MongoDB\Builder\Type\Optional;
use MongoDB\Builder\Type\QueryInterface;
use MongoDB\Model\BSONArray;
use stdClass;
/**
 * @internal
 */
trait FactoryTrait
{
    /**
     * Matches arrays that contain all elements specified in the query.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/query/all/
     * @no-named-arguments
     * @param DateTimeInterface|FieldQueryInterface|Type|array|bool|float|int|null|stdClass|string ...$value
     */
    public static function all(DateTimeInterface|Type|FieldQueryInterface|stdClass|array|bool|float|int|null|string ...$value): \MongoDB\Builder\Query\AllOperator
    {
        return new \MongoDB\Builder\Query\AllOperator(...$value);
    }
    /**
     * Joins query clauses with a logical AND returns all documents that match the conditions of both clauses.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/query/and/
     * @no-named-arguments
     * @param QueryInterface|array ...$queries
     */
    public static function and(QueryInterface|array ...$queries): \MongoDB\Builder\Query\AndOperator
    {
        return new \MongoDB\Builder\Query\AndOperator(...$queries);
    }
    /**
     * Matches numeric or binary values in which a set of bit positions all have a value of 0.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/query/bitsAllClear/
     * @param BSONArray|Binary|PackedArray|array|int|string $bitmask
     */
    public static function bitsAllClear(Binary|PackedArray|BSONArray|array|int|string $bitmask): \MongoDB\Builder\Query\BitsAllClearOperator
    {
        return new \MongoDB\Builder\Query\BitsAllClearOperator($bitmask);
    }
    /**
     * Matches numeric or binary values in which a set of bit positions all have a value of 1.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/query/bitsAllSet/
     * @param BSONArray|Binary|PackedArray|array|int|string $bitmask
     */
    public static function bitsAllSet(Binary|PackedArray|BSONArray|array|int|string $bitmask): \MongoDB\Builder\Query\BitsAllSetOperator
    {
        return new \MongoDB\Builder\Query\BitsAllSetOperator($bitmask);
    }
    /**
     * Matches numeric or binary values in which any bit from a set of bit positions has a value of 0.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/query/bitsAnyClear/
     * @param BSONArray|Binary|PackedArray|array|int|string $bitmask
     */
    public static function bitsAnyClear(Binary|PackedArray|BSONArray|array|int|string $bitmask): \MongoDB\Builder\Query\BitsAnyClearOperator
    {
        return new \MongoDB\Builder\Query\BitsAnyClearOperator($bitmask);
    }
    /**
     * Matches numeric or binary values in which any bit from a set of bit positions has a value of 1.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/query/bitsAnySet/
     * @param BSONArray|Binary|PackedArray|array|int|string $bitmask
     */
    public static function bitsAnySet(Binary|PackedArray|BSONArray|array|int|string $bitmask): \MongoDB\Builder\Query\BitsAnySetOperator
    {
        return new \MongoDB\Builder\Query\BitsAnySetOperator($bitmask);
    }
    /**
     * Specifies a rectangular box using legacy coordinate pairs for $geoWithin queries. The 2d index supports $box.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/query/box/
     * @param BSONArray|PackedArray|array $value
     */
    public static function box(PackedArray|BSONArray|array $value): \MongoDB\Builder\Query\BoxOperator
    {
        return new \MongoDB\Builder\Query\BoxOperator($value);
    }
    /**
     * Specifies a circle using legacy coordinate pairs to $geoWithin queries when using planar geometry. The 2d index supports $center.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/query/center/
     * @param BSONArray|PackedArray|array $value
     */
    public static function center(PackedArray|BSONArray|array $value): \MongoDB\Builder\Query\CenterOperator
    {
        return new \MongoDB\Builder\Query\CenterOperator($value);
    }
    /**
     * Specifies a circle using either legacy coordinate pairs or GeoJSON format for $geoWithin queries when using spherical geometry. The 2dsphere and 2d indexes support $centerSphere.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/query/centerSphere/
     * @param BSONArray|PackedArray|array $value
     */
    public static function centerSphere(PackedArray|BSONArray|array $value): \MongoDB\Builder\Query\CenterSphereOperator
    {
        return new \MongoDB\Builder\Query\CenterSphereOperator($value);
    }
    /**
     * Adds a comment to a query predicate.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/query/comment/
     * @param string $comment
     */
    public static function comment(string $comment): \MongoDB\Builder\Query\CommentOperator
    {
        return new \MongoDB\Builder\Query\CommentOperator($comment);
    }
    /**
     * The $elemMatch operator matches documents that contain an array field with at least one element that matches all the specified query criteria.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/query/elemMatch/
     * @param DateTimeInterface|FieldQueryInterface|QueryInterface|Type|array|bool|float|int|null|stdClass|string $query
     */
    public static function elemMatch(DateTimeInterface|Type|FieldQueryInterface|QueryInterface|stdClass|array|bool|float|int|null|string $query): \MongoDB\Builder\Query\ElemMatchOperator
    {
        return new \MongoDB\Builder\Query\ElemMatchOperator($query);
    }
    /**
     * Matches values that are equal to a specified value.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/query/eq/
     * @param DateTimeInterface|Type|array|bool|float|int|null|stdClass|string $value
     */
    public static function eq(DateTimeInterface|Type|stdClass|array|bool|float|int|null|string $value): \MongoDB\Builder\Query\EqOperator
    {
        return new \MongoDB\Builder\Query\EqOperator($value);
    }
    /**
     * Matches documents that have the specified field.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/query/exists/
     * @param bool $exists
     */
    public static function exists(bool $exists = \true): \MongoDB\Builder\Query\ExistsOperator
    {
        return new \MongoDB\Builder\Query\ExistsOperator($exists);
    }
    /**
     * Allows use of aggregation expressions within the query language.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/query/expr/
     * @param DateTimeInterface|ExpressionInterface|Type|array|bool|float|int|null|stdClass|string $expression
     */
    public static function expr(DateTimeInterface|Type|ExpressionInterface|stdClass|array|bool|float|int|null|string $expression): \MongoDB\Builder\Query\ExprOperator
    {
        return new \MongoDB\Builder\Query\ExprOperator($expression);
    }
    /**
     * Selects geometries that intersect with a GeoJSON geometry. The 2dsphere index supports $geoIntersects.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/query/geoIntersects/
     * @param Document|GeometryInterface|Serializable|array|stdClass $geometry
     */
    public static function geoIntersects(Document|Serializable|GeometryInterface|stdClass|array $geometry): \MongoDB\Builder\Query\GeoIntersectsOperator
    {
        return new \MongoDB\Builder\Query\GeoIntersectsOperator($geometry);
    }
    /**
     * Specifies a geometry in GeoJSON format to geospatial query operators.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/query/geometry/
     * @param string $type
     * @param BSONArray|PackedArray|array $coordinates
     * @param Optional|Document|Serializable|array|stdClass $crs
     */
    public static function geometry(string $type, PackedArray|BSONArray|array $coordinates, Optional|Document|Serializable|stdClass|array $crs = Optional::Undefined): \MongoDB\Builder\Query\GeometryOperator
    {
        return new \MongoDB\Builder\Query\GeometryOperator($type, $coordinates, $crs);
    }
    /**
     * Selects geometries within a bounding GeoJSON geometry. The 2dsphere and 2d indexes support $geoWithin.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/query/geoWithin/
     * @param Document|GeometryInterface|Serializable|array|stdClass $geometry
     */
    public static function geoWithin(Document|Serializable|GeometryInterface|stdClass|array $geometry): \MongoDB\Builder\Query\GeoWithinOperator
    {
        return new \MongoDB\Builder\Query\GeoWithinOperator($geometry);
    }
    /**
     * Matches values that are greater than a specified value.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/query/gt/
     * @param DateTimeInterface|Type|array|bool|float|int|null|stdClass|string $value
     */
    public static function gt(DateTimeInterface|Type|stdClass|array|bool|float|int|null|string $value): \MongoDB\Builder\Query\GtOperator
    {
        return new \MongoDB\Builder\Query\GtOperator($value);
    }
    /**
     * Matches values that are greater than or equal to a specified value.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/query/gte/
     * @param DateTimeInterface|Type|array|bool|float|int|null|stdClass|string $value
     */
    public static function gte(DateTimeInterface|Type|stdClass|array|bool|float|int|null|string $value): \MongoDB\Builder\Query\GteOperator
    {
        return new \MongoDB\Builder\Query\GteOperator($value);
    }
    /**
     * Matches any of the values specified in an array.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/query/in/
     * @param BSONArray|PackedArray|array $value
     */
    public static function in(PackedArray|BSONArray|array $value): \MongoDB\Builder\Query\InOperator
    {
        return new \MongoDB\Builder\Query\InOperator($value);
    }
    /**
     * Validate documents against the given JSON Schema.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/query/jsonSchema/
     * @param Document|Serializable|array|stdClass $schema
     */
    public static function jsonSchema(Document|Serializable|stdClass|array $schema): \MongoDB\Builder\Query\JsonSchemaOperator
    {
        return new \MongoDB\Builder\Query\JsonSchemaOperator($schema);
    }
    /**
     * Matches values that are less than a specified value.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/query/lt/
     * @param DateTimeInterface|Type|array|bool|float|int|null|stdClass|string $value
     */
    public static function lt(DateTimeInterface|Type|stdClass|array|bool|float|int|null|string $value): \MongoDB\Builder\Query\LtOperator
    {
        return new \MongoDB\Builder\Query\LtOperator($value);
    }
    /**
     * Matches values that are less than or equal to a specified value.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/query/lte/
     * @param DateTimeInterface|Type|array|bool|float|int|null|stdClass|string $value
     */
    public static function lte(DateTimeInterface|Type|stdClass|array|bool|float|int|null|string $value): \MongoDB\Builder\Query\LteOperator
    {
        return new \MongoDB\Builder\Query\LteOperator($value);
    }
    /**
     * Specifies a maximum distance to limit the results of $near and $nearSphere queries. The 2dsphere and 2d indexes support $maxDistance.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/query/maxDistance/
     * @param Decimal128|Int64|float|int $value
     */
    public static function maxDistance(Decimal128|Int64|float|int $value): \MongoDB\Builder\Query\MaxDistanceOperator
    {
        return new \MongoDB\Builder\Query\MaxDistanceOperator($value);
    }
    /**
     * Specifies a minimum distance to limit the results of $near and $nearSphere queries. For use with 2dsphere index only.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/query/minDistance/
     * @param Int64|float|int $value
     */
    public static function minDistance(Int64|float|int $value): \MongoDB\Builder\Query\MinDistanceOperator
    {
        return new \MongoDB\Builder\Query\MinDistanceOperator($value);
    }
    /**
     * Performs a modulo operation on the value of a field and selects documents with a specified result.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/query/mod/
     * @param Decimal128|Int64|float|int $divisor
     * @param Decimal128|Int64|float|int $remainder
     */
    public static function mod(Decimal128|Int64|float|int $divisor, Decimal128|Int64|float|int $remainder): \MongoDB\Builder\Query\ModOperator
    {
        return new \MongoDB\Builder\Query\ModOperator($divisor, $remainder);
    }
    /**
     * Matches all values that are not equal to a specified value.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/query/ne/
     * @param DateTimeInterface|Type|array|bool|float|int|null|stdClass|string $value
     */
    public static function ne(DateTimeInterface|Type|stdClass|array|bool|float|int|null|string $value): \MongoDB\Builder\Query\NeOperator
    {
        return new \MongoDB\Builder\Query\NeOperator($value);
    }
    /**
     * Returns geospatial objects in proximity to a point. Requires a geospatial index. The 2dsphere and 2d indexes support $near.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/query/near/
     * @param Document|GeometryInterface|Serializable|array|stdClass $geometry
     * @param Optional|Decimal128|Int64|float|int $maxDistance Distance in meters. Limits the results to those documents that are at most the specified distance from the center point.
     * @param Optional|Decimal128|Int64|float|int $minDistance Distance in meters. Limits the results to those documents that are at least the specified distance from the center point.
     */
    public static function near(Document|Serializable|GeometryInterface|stdClass|array $geometry, Optional|Decimal128|Int64|float|int $maxDistance = Optional::Undefined, Optional|Decimal128|Int64|float|int $minDistance = Optional::Undefined): \MongoDB\Builder\Query\NearOperator
    {
        return new \MongoDB\Builder\Query\NearOperator($geometry, $maxDistance, $minDistance);
    }
    /**
     * Returns geospatial objects in proximity to a point on a sphere. Requires a geospatial index. The 2dsphere and 2d indexes support $nearSphere.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/query/nearSphere/
     * @param Document|GeometryInterface|Serializable|array|stdClass $geometry
     * @param Optional|Decimal128|Int64|float|int $maxDistance Distance in meters.
     * @param Optional|Decimal128|Int64|float|int $minDistance Distance in meters. Limits the results to those documents that are at least the specified distance from the center point.
     */
    public static function nearSphere(Document|Serializable|GeometryInterface|stdClass|array $geometry, Optional|Decimal128|Int64|float|int $maxDistance = Optional::Undefined, Optional|Decimal128|Int64|float|int $minDistance = Optional::Undefined): \MongoDB\Builder\Query\NearSphereOperator
    {
        return new \MongoDB\Builder\Query\NearSphereOperator($geometry, $maxDistance, $minDistance);
    }
    /**
     * Matches none of the values specified in an array.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/query/nin/
     * @param BSONArray|PackedArray|array $value
     */
    public static function nin(PackedArray|BSONArray|array $value): \MongoDB\Builder\Query\NinOperator
    {
        return new \MongoDB\Builder\Query\NinOperator($value);
    }
    /**
     * Joins query clauses with a logical NOR returns all documents that fail to match both clauses.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/query/nor/
     * @no-named-arguments
     * @param QueryInterface|array ...$queries
     */
    public static function nor(QueryInterface|array ...$queries): \MongoDB\Builder\Query\NorOperator
    {
        return new \MongoDB\Builder\Query\NorOperator(...$queries);
    }
    /**
     * Inverts the effect of a query expression and returns documents that do not match the query expression.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/query/not/
     * @param DateTimeInterface|FieldQueryInterface|Type|array|bool|float|int|null|stdClass|string $expression
     */
    public static function not(DateTimeInterface|Type|FieldQueryInterface|stdClass|array|bool|float|int|null|string $expression): \MongoDB\Builder\Query\NotOperator
    {
        return new \MongoDB\Builder\Query\NotOperator($expression);
    }
    /**
     * Joins query clauses with a logical OR returns all documents that match the conditions of either clause.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/query/or/
     * @no-named-arguments
     * @param QueryInterface|array ...$queries
     */
    public static function or(QueryInterface|array ...$queries): \MongoDB\Builder\Query\OrOperator
    {
        return new \MongoDB\Builder\Query\OrOperator(...$queries);
    }
    /**
     * Specifies a polygon to using legacy coordinate pairs for $geoWithin queries. The 2d index supports $center.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/query/polygon/
     * @param BSONArray|PackedArray|array $points
     */
    public static function polygon(PackedArray|BSONArray|array $points): \MongoDB\Builder\Query\PolygonOperator
    {
        return new \MongoDB\Builder\Query\PolygonOperator($points);
    }
    /**
     * Generates a random float between 0 and 1.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/query/rand/
     */
    public static function rand(): \MongoDB\Builder\Query\RandOperator
    {
        return new \MongoDB\Builder\Query\RandOperator();
    }
    /**
     * Selects documents where values match a specified regular expression.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/query/regex/
     * @param Regex $regex
     */
    public static function regex(Regex $regex): \MongoDB\Builder\Query\RegexOperator
    {
        return new \MongoDB\Builder\Query\RegexOperator($regex);
    }
    /**
     * Randomly select documents at a given rate. Although the exact number of documents selected varies on each run, the quantity chosen approximates the sample rate expressed as a percentage of the total number of documents.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/sampleRate/
     * @param Int64|ResolvesToDouble|float|int|string $rate The selection process uses a uniform random distribution. The sample rate is a floating point number between 0 and 1, inclusive, which represents the probability that a given document will be selected as it passes through the pipeline.
     * For example, a sample rate of 0.33 selects roughly one document in three.
     */
    public static function sampleRate(Int64|ResolvesToDouble|float|int|string $rate): \MongoDB\Builder\Query\SampleRateOperator
    {
        return new \MongoDB\Builder\Query\SampleRateOperator($rate);
    }
    /**
     * Selects documents if the array field is a specified size.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/query/size/
     * @param int $value
     */
    public static function size(int $value): \MongoDB\Builder\Query\SizeOperator
    {
        return new \MongoDB\Builder\Query\SizeOperator($value);
    }
    /**
     * Performs text search.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/query/text/
     * @param string $search A string of terms that MongoDB parses and uses to query the text index. MongoDB performs a logical OR search of the terms unless specified as a phrase.
     * @param Optional|string $language The language that determines the list of stop words for the search and the rules for the stemmer and tokenizer. If not specified, the search uses the default language of the index.
     * If you specify a default_language value of none, then the text index parses through each word in the field, including stop words, and ignores suffix stemming.
     * @param Optional|bool $caseSensitive A boolean flag to enable or disable case sensitive search. Defaults to false; i.e. the search defers to the case insensitivity of the text index.
     * @param Optional|bool $diacriticSensitive A boolean flag to enable or disable diacritic sensitive search against version 3 text indexes. Defaults to false; i.e. the search defers to the diacritic insensitivity of the text index.
     * Text searches against earlier versions of the text index are inherently diacritic sensitive and cannot be diacritic insensitive. As such, the $diacriticSensitive option has no effect with earlier versions of the text index.
     */
    public static function text(string $search, Optional|string $language = Optional::Undefined, Optional|bool $caseSensitive = Optional::Undefined, Optional|bool $diacriticSensitive = Optional::Undefined): \MongoDB\Builder\Query\TextOperator
    {
        return new \MongoDB\Builder\Query\TextOperator($search, $language, $caseSensitive, $diacriticSensitive);
    }
    /**
     * Selects documents if a field is of the specified type.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/query/type/
     * @no-named-arguments
     * @param int|string ...$type
     */
    public static function type(int|string ...$type): \MongoDB\Builder\Query\TypeOperator
    {
        return new \MongoDB\Builder\Query\TypeOperator(...$type);
    }
    /**
     * Matches documents that satisfy a JavaScript expression.
     *
     * @see https://www.mongodb.com/docs/manual/reference/operator/query/where/
     * @param Javascript|string $function
     */
    public static function where(Javascript|string $function): \MongoDB\Builder\Query\WhereOperator
    {
        return new \MongoDB\Builder\Query\WhereOperator($function);
    }
}
