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
 * Returns a count of the number of documents at this stage of the aggregation pipeline.
 * Distinct from the $count aggregation accumulator.
 *
 * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/count/
 * @internal
 */
final class CountStage implements StageInterface, OperatorInterface
{
    public const ENCODE = Encode::Single;
    public const NAME = '$count';
    public const PROPERTIES = ['field' => 'field'];
    /** @var string $field Name of the output field which has the count as its value. It must be a non-empty string, must not start with $ and must not contain the . character. */
    public readonly string $field;
    /**
     * @param string $field Name of the output field which has the count as its value. It must be a non-empty string, must not start with $ and must not contain the . character.
     */
    public function __construct(string $field)
    {
        $this->field = $field;
    }
}
