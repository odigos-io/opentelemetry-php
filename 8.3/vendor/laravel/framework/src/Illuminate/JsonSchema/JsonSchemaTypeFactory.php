<?php

namespace Illuminate\JsonSchema;

use Closure;
use Illuminate\Contracts\JsonSchema\JsonSchema as JsonSchemaContract;
class JsonSchemaTypeFactory extends \Illuminate\JsonSchema\JsonSchema implements JsonSchemaContract
{
    /**
     * Create a new object schema instance.
     *
     * @param  (Closure(JsonSchemaTypeFactory): array<string, Types\Type>)|array<string, Types\Type>  $properties
     */
    public function object(Closure|array $properties = []): \Illuminate\JsonSchema\Types\ObjectType
    {
        if ($properties instanceof Closure) {
            $properties = $properties($this);
        }
        return new \Illuminate\JsonSchema\Types\ObjectType($properties);
    }
    /**
     * Create a new array property instance.
     */
    public function array(): \Illuminate\JsonSchema\Types\ArrayType
    {
        return new \Illuminate\JsonSchema\Types\ArrayType();
    }
    /**
     * Create a new string property instance.
     */
    public function string(): \Illuminate\JsonSchema\Types\StringType
    {
        return new \Illuminate\JsonSchema\Types\StringType();
    }
    /**
     * Create a new integer property instance.
     */
    public function integer(): \Illuminate\JsonSchema\Types\IntegerType
    {
        return new \Illuminate\JsonSchema\Types\IntegerType();
    }
    /**
     * Create a new number property instance.
     */
    public function number(): \Illuminate\JsonSchema\Types\NumberType
    {
        return new \Illuminate\JsonSchema\Types\NumberType();
    }
    /**
     * Create a new boolean property instance.
     */
    public function boolean(): \Illuminate\JsonSchema\Types\BooleanType
    {
        return new \Illuminate\JsonSchema\Types\BooleanType();
    }
}
