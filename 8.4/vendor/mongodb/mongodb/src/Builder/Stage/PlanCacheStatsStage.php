<?php

/**
 * THIS FILE IS AUTO-GENERATED. ANY CHANGES WILL BE LOST!
 */
declare (strict_types=1);
namespace Odigos\MongoDB\Builder\Stage;

use Odigos\MongoDB\Builder\Type\Encode;
use Odigos\MongoDB\Builder\Type\OperatorInterface;
use Odigos\MongoDB\Builder\Type\StageInterface;
/**
 * Returns plan cache information for a collection.
 *
 * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/planCacheStats/
 * @internal
 */
final class PlanCacheStatsStage implements StageInterface, OperatorInterface
{
    public const ENCODE = Encode::Object;
    public const NAME = '$planCacheStats';
    public function __construct()
    {
    }
}
