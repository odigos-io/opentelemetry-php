<?php

/**
 * THIS FILE IS AUTO-GENERATED. ANY CHANGES WILL BE LOST!
 */
declare (strict_types=1);
namespace Odigos\MongoDB\Builder\Accumulator;

use Odigos\MongoDB\Builder\Type\Encode;
use Odigos\MongoDB\Builder\Type\OperatorInterface;
use Odigos\MongoDB\Builder\Type\WindowInterface;
/**
 * Returns the document position (known as the rank) relative to other documents in the $setWindowFields stage partition.
 * New in MongoDB 5.0.
 *
 * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/rank/
 * @internal
 */
final class RankAccumulator implements WindowInterface, OperatorInterface
{
    public const ENCODE = Encode::Object;
    public const NAME = '$rank';
    public function __construct()
    {
    }
}
