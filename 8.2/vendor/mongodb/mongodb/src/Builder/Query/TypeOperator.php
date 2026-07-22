<?php

/**
 * THIS FILE IS AUTO-GENERATED. ANY CHANGES WILL BE LOST!
 */
declare (strict_types=1);
namespace Odigos\MongoDB\Builder\Query;

use Odigos\MongoDB\Builder\Type\Encode;
use Odigos\MongoDB\Builder\Type\FieldQueryInterface;
use Odigos\MongoDB\Builder\Type\OperatorInterface;
use Odigos\MongoDB\Exception\InvalidArgumentException;
use function array_is_list;
/**
 * Selects documents if a field is of the specified type.
 *
 * @see https://www.mongodb.com/docs/manual/reference/operator/query/type/
 * @internal
 */
final class TypeOperator implements FieldQueryInterface, OperatorInterface
{
    public const ENCODE = Encode::Single;
    public const NAME = '$type';
    public const PROPERTIES = ['type' => 'type'];
    /** @var list<int|string> $type */
    public readonly array $type;
    /**
     * @param int|string ...$type
     * @no-named-arguments
     */
    public function __construct(int|string ...$type)
    {
        if (\count($type) < 1) {
            throw new InvalidArgumentException(\sprintf('Expected at least %d values for $type, got %d.', 1, \count($type)));
        }
        if (!array_is_list($type)) {
            throw new InvalidArgumentException('Expected $type arguments to be a list (array), named arguments are not supported');
        }
        $this->type = $type;
    }
}
