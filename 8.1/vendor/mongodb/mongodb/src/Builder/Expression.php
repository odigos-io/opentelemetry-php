<?php

declare (strict_types=1);
namespace MongoDB\Builder;

/**
 * Factories for Aggregation Pipeline Expression Operators
 *
 * @see https://docs.mongodb.com/manual/reference/operator/aggregation/
 */
final class Expression
{
    use \MongoDB\Builder\Expression\ExpressionFactoryTrait;
    use \MongoDB\Builder\Expression\FactoryTrait;
    private function __construct()
    {
        // This class cannot be instantiated
    }
}
