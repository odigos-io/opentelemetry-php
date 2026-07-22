<?php

/**
 * THIS FILE IS AUTO-GENERATED. ANY CHANGES WILL BE LOST!
 */
declare (strict_types=1);
namespace Odigos\MongoDB\Builder\Stage;

use DateTimeInterface;
use MongoDB\BSON\Type;
use Odigos\MongoDB\Builder\Type\Encode;
use Odigos\MongoDB\Builder\Type\ExpressionInterface;
use Odigos\MongoDB\Builder\Type\OperatorInterface;
use Odigos\MongoDB\Builder\Type\StageInterface;
use stdClass;
/**
 * Reshapes each document in the stream by restricting the content for each document based on information stored in the documents themselves. Incorporates the functionality of $project and $match. Can be used to implement field level redaction. For each input document, outputs either one or zero documents.
 *
 * @see https://www.mongodb.com/docs/manual/reference/operator/aggregation/redact/
 * @internal
 */
final class RedactStage implements StageInterface, OperatorInterface
{
    public const ENCODE = Encode::Single;
    public const NAME = '$redact';
    public const PROPERTIES = ['expression' => 'expression'];
    /** @var DateTimeInterface|ExpressionInterface|Type|array|bool|float|int|null|stdClass|string $expression */
    public readonly DateTimeInterface|Type|ExpressionInterface|stdClass|array|bool|float|int|null|string $expression;
    /**
     * @param DateTimeInterface|ExpressionInterface|Type|array|bool|float|int|null|stdClass|string $expression
     */
    public function __construct(DateTimeInterface|Type|ExpressionInterface|stdClass|array|bool|float|int|null|string $expression)
    {
        $this->expression = $expression;
    }
}
