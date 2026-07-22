<?php

/**
 * THIS FILE IS AUTO-GENERATED. ANY CHANGES WILL BE LOST!
 */
declare (strict_types=1);
namespace Odigos\MongoDB\Builder\Query;

use MongoDB\BSON\Binary;
use MongoDB\BSON\PackedArray;
use Odigos\MongoDB\Builder\Type\Encode;
use Odigos\MongoDB\Builder\Type\FieldQueryInterface;
use Odigos\MongoDB\Builder\Type\OperatorInterface;
use Odigos\MongoDB\Exception\InvalidArgumentException;
use Odigos\MongoDB\Model\BSONArray;
use function array_is_list;
use function is_array;
/**
 * Matches numeric or binary values in which any bit from a set of bit positions has a value of 1.
 *
 * @see https://www.mongodb.com/docs/manual/reference/operator/query/bitsAnySet/
 * @internal
 */
final class BitsAnySetOperator implements FieldQueryInterface, OperatorInterface
{
    public const ENCODE = Encode::Single;
    public const NAME = '$bitsAnySet';
    public const PROPERTIES = ['bitmask' => 'bitmask'];
    /** @var BSONArray|Binary|PackedArray|array|int|string $bitmask */
    public readonly Binary|PackedArray|BSONArray|array|int|string $bitmask;
    /**
     * @param BSONArray|Binary|PackedArray|array|int|string $bitmask
     */
    public function __construct(Binary|PackedArray|BSONArray|array|int|string $bitmask)
    {
        if (is_array($bitmask) && !array_is_list($bitmask)) {
            throw new InvalidArgumentException('Expected $bitmask argument to be a list, got an associative array.');
        }
        $this->bitmask = $bitmask;
    }
}
