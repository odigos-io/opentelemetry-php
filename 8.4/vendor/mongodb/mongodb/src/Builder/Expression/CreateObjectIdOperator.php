<?php

/**
 * THIS FILE IS AUTO-GENERATED. ANY CHANGES WILL BE LOST!
 */
declare (strict_types=1);
namespace Odigos\MongoDB\Builder\Expression;

use Odigos\MongoDB\Builder\Type\Encode;
use Odigos\MongoDB\Builder\Type\OperatorInterface;
/**
 * Returns a random object ID
 *
 * New in MongoDB 4.4
 *
 * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/createObjectId/
 * @internal
 */
final class CreateObjectIdOperator implements ResolvesToObjectId, OperatorInterface
{
    public const ENCODE = Encode::Object;
    public const NAME = '$createObjectId';
    public function __construct()
    {
    }
}
