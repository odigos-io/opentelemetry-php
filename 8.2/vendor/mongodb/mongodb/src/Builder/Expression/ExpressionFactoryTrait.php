<?php

/**
 * THIS FILE IS AUTO-GENERATED. ANY CHANGES WILL BE LOST!
 */
declare (strict_types=1);
namespace MongoDB\Builder\Expression;

/**
 * @internal
 */
trait ExpressionFactoryTrait
{
    public static function arrayFieldPath(string $name): \MongoDB\Builder\Expression\ArrayFieldPath
    {
        return new \MongoDB\Builder\Expression\ArrayFieldPath($name);
    }
    public static function binDataFieldPath(string $name): \MongoDB\Builder\Expression\BinDataFieldPath
    {
        return new \MongoDB\Builder\Expression\BinDataFieldPath($name);
    }
    public static function boolFieldPath(string $name): \MongoDB\Builder\Expression\BoolFieldPath
    {
        return new \MongoDB\Builder\Expression\BoolFieldPath($name);
    }
    public static function dateFieldPath(string $name): \MongoDB\Builder\Expression\DateFieldPath
    {
        return new \MongoDB\Builder\Expression\DateFieldPath($name);
    }
    public static function decimalFieldPath(string $name): \MongoDB\Builder\Expression\DecimalFieldPath
    {
        return new \MongoDB\Builder\Expression\DecimalFieldPath($name);
    }
    public static function doubleFieldPath(string $name): \MongoDB\Builder\Expression\DoubleFieldPath
    {
        return new \MongoDB\Builder\Expression\DoubleFieldPath($name);
    }
    public static function fieldPath(string $name): \MongoDB\Builder\Expression\FieldPath
    {
        return new \MongoDB\Builder\Expression\FieldPath($name);
    }
    public static function intFieldPath(string $name): \MongoDB\Builder\Expression\IntFieldPath
    {
        return new \MongoDB\Builder\Expression\IntFieldPath($name);
    }
    public static function javascriptFieldPath(string $name): \MongoDB\Builder\Expression\JavascriptFieldPath
    {
        return new \MongoDB\Builder\Expression\JavascriptFieldPath($name);
    }
    public static function longFieldPath(string $name): \MongoDB\Builder\Expression\LongFieldPath
    {
        return new \MongoDB\Builder\Expression\LongFieldPath($name);
    }
    public static function nullFieldPath(string $name): \MongoDB\Builder\Expression\NullFieldPath
    {
        return new \MongoDB\Builder\Expression\NullFieldPath($name);
    }
    public static function numberFieldPath(string $name): \MongoDB\Builder\Expression\NumberFieldPath
    {
        return new \MongoDB\Builder\Expression\NumberFieldPath($name);
    }
    public static function objectFieldPath(string $name): \MongoDB\Builder\Expression\ObjectFieldPath
    {
        return new \MongoDB\Builder\Expression\ObjectFieldPath($name);
    }
    public static function objectIdFieldPath(string $name): \MongoDB\Builder\Expression\ObjectIdFieldPath
    {
        return new \MongoDB\Builder\Expression\ObjectIdFieldPath($name);
    }
    public static function regexFieldPath(string $name): \MongoDB\Builder\Expression\RegexFieldPath
    {
        return new \MongoDB\Builder\Expression\RegexFieldPath($name);
    }
    public static function stringFieldPath(string $name): \MongoDB\Builder\Expression\StringFieldPath
    {
        return new \MongoDB\Builder\Expression\StringFieldPath($name);
    }
    public static function timestampFieldPath(string $name): \MongoDB\Builder\Expression\TimestampFieldPath
    {
        return new \MongoDB\Builder\Expression\TimestampFieldPath($name);
    }
    public static function variable(string $name): \MongoDB\Builder\Expression\Variable
    {
        return new \MongoDB\Builder\Expression\Variable($name);
    }
}
