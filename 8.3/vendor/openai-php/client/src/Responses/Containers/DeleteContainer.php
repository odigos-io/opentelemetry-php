<?php

declare (strict_types=1);
namespace Odigos\OpenAI\Responses\Containers;

use Odigos\OpenAI\Contracts\ResponseContract;
use Odigos\OpenAI\Contracts\ResponseHasMetaInformationContract;
use Odigos\OpenAI\Responses\Concerns\ArrayAccessible;
use Odigos\OpenAI\Responses\Concerns\HasMetaInformation;
use Odigos\OpenAI\Responses\Meta\MetaInformation;
use Odigos\OpenAI\Testing\Responses\Concerns\Fakeable;
/**
 * @phpstan-type DeleteContainerType array{id: string, object: string, deleted: bool}
 *
 * @implements ResponseContract<DeleteContainerType>
 */
final class DeleteContainer implements ResponseContract, ResponseHasMetaInformationContract
{
    /**
     * @use ArrayAccessible<DeleteContainerType>
     */
    use ArrayAccessible;
    use Fakeable;
    use HasMetaInformation;
    private function __construct(public readonly string $id, public readonly string $object, public readonly bool $deleted, private readonly MetaInformation $meta)
    {
    }
    /**
     * @param  DeleteContainerType  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        return new self(id: $attributes['id'], object: $attributes['object'], deleted: $attributes['deleted'], meta: $meta);
    }
    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return ['id' => $this->id, 'object' => $this->object, 'deleted' => $this->deleted];
    }
}
