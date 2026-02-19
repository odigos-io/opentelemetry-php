<?php

namespace Illuminate\JsonSchema;

use RuntimeException;
class Serializer
{
    /**
     * The properties to ignore when serializing.
     *
     * @var array<int, string>
     */
    protected static array $ignore = ['required', 'nullable'];
    /**
     * Serialize the given property to an array.
     *
     * @return array<string, mixed>
     */
    public static function serialize(\Illuminate\JsonSchema\Types\Type $type): array
    {
        /** @var array<string, mixed> $attributes */
        $attributes = (fn() => get_object_vars($type))->call($type);
        $attributes['type'] = match (get_class($type)) {
            \Illuminate\JsonSchema\Types\ArrayType::class => 'array',
            \Illuminate\JsonSchema\Types\BooleanType::class => 'boolean',
            \Illuminate\JsonSchema\Types\IntegerType::class => 'integer',
            \Illuminate\JsonSchema\Types\NumberType::class => 'number',
            \Illuminate\JsonSchema\Types\ObjectType::class => 'object',
            \Illuminate\JsonSchema\Types\StringType::class => 'string',
            default => throw new RuntimeException('Unsupported [' . get_class($type) . '] type.'),
        };
        $nullable = static::isNullable($type);
        if ($nullable) {
            $attributes['type'] = [$attributes['type'], 'null'];
        }
        $attributes = array_filter($attributes, static function (mixed $value, string $key) {
            if (in_array($key, static::$ignore, \true)) {
                return \false;
            }
            return $value !== null;
        }, \ARRAY_FILTER_USE_BOTH);
        if ($type instanceof \Illuminate\JsonSchema\Types\ObjectType) {
            if (count($attributes['properties']) === 0) {
                unset($attributes['properties']);
            } else {
                $required = array_keys(array_filter($attributes['properties'], static fn(\Illuminate\JsonSchema\Types\Type $property) => static::isRequired($property)));
                if (count($required) > 0) {
                    $attributes['required'] = $required;
                }
                $attributes['properties'] = array_map(static fn(\Illuminate\JsonSchema\Types\Type $property) => static::serialize($property), $attributes['properties']);
            }
        }
        if ($type instanceof \Illuminate\JsonSchema\Types\ArrayType) {
            if (isset($attributes['items']) && $attributes['items'] instanceof \Illuminate\JsonSchema\Types\Type) {
                $attributes['items'] = static::serialize($attributes['items']);
            }
        }
        return $attributes;
    }
    /**
     * Determine if the given type is required.
     */
    protected static function isRequired(\Illuminate\JsonSchema\Types\Type $type): bool
    {
        $attributes = (fn() => get_object_vars($type))->call($type);
        return isset($attributes['required']) && $attributes['required'] === \true;
    }
    /**
     * Determine if the given type is nullable.
     */
    protected static function isNullable(\Illuminate\JsonSchema\Types\Type $type): bool
    {
        $attributes = (fn() => get_object_vars($type))->call($type);
        return isset($attributes['nullable']) && $attributes['nullable'] === \true;
    }
}
